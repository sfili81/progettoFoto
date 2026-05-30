<?php

namespace backend\controllers;

use Yii;
use common\models\Gara;
use common\models\GaraFoto;
use backend\models\Image;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\Response;
use yii\filters\VerbFilter;

class FotoGaraController extends Controller
{
    const PAGE_SIZE = 24;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'upload'         => ['POST'],
                    'delete-photo'   => ['POST'],
                    'photo-list'     => ['GET'],
                    'import-folder'  => ['POST'],
                    'list-folder'    => ['GET'],
                ],
            ],
        ]);
    }

    /**
     * Form principale: selezione foglia + FileInput con preview delle foto già caricate.
     */
    public function actionIndex($gara_id = null)
    {
        $leafOptions  = $this->buildLeafOptions();
        $fotos        = [];
        $totalFotos   = 0;
        $selectedNode = null;

        if ($gara_id !== null) {
            $selectedNode = Gara::findOne((int) $gara_id);

            if ($selectedNode && $selectedNode->isLeaf()) {
                FileHelper::createDirectory($selectedNode->getFolderPath(), 0755, true);
                $totalFotos = GaraFoto::findByGara((int) $gara_id)->count();
                $fotos      = GaraFoto::findByGara((int) $gara_id)->limit(self::PAGE_SIZE)->all();
            } else {
                $selectedNode = null;
            }
        }

        return $this->render('index', [
            'leafOptions'  => $leafOptions,
            'gara_id'      => $gara_id !== null ? (int) $gara_id : null,
            'selectedNode' => $selectedNode,
            'fotos'        => $fotos,
            'totalFotos'   => $totalFotos,
        ]);
    }

    /**
     * Endpoint AJAX: restituisce una pagina di foto (JSON) per il lazy load della griglia.
     */
    public function actionPhotoList($gara_id, $page = 1)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $gara_id = (int) $gara_id;
        $page    = max(1, (int) $page);

        $node = Gara::findOne($gara_id);
        if (!$node || !$node->isLeaf()) {
            return ['error' => 'Categoria non valida.'];
        }

        $fotos = GaraFoto::findByGara($gara_id)
            ->offset(($page - 1) * self::PAGE_SIZE)
            ->limit(self::PAGE_SIZE)
            ->all();

        $total = GaraFoto::findByGara($gara_id)->count();

        $items = [];
        foreach ($fotos as $garaFoto) {
            $img = $garaFoto->image;
            if (!$img) {
                continue;
            }
            $items[] = [
                'id'      => $garaFoto->id,
                'url'     => Yii::getAlias('@frontendUploads') . '/' . $img->img_name . $img->img_extension,
                'caption' => $img->img_show_name ?: basename($img->img_name),
            ];
        }

        return [
            'items'   => $items,
            'total'   => $total,
            'page'    => $page,
            'hasMore' => ($page * self::PAGE_SIZE) < $total,
        ];
    }

    /**
     * Endpoint AJAX (kartik FileInput): converte in WebP tramite Image::uploadSingleImage(),
     * sposta il file nella cartella gara, crea il record `image` e il collegamento `gara_foto`.
     */
    public function actionUpload()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $gara_id = (int) Yii::$app->request->post('gara_id');
        $node    = Gara::findOne($gara_id);

        if (!$node || !$node->isLeaf()) {
            return ['error' => 'Categoria non valida o non è una foglia.'];
        }

        $folderPath = $node->getFolderPath();
        FileHelper::createDirectory($folderPath, 0755, true);

        $imagesRoot = Yii::getAlias('@frontend') . '/web/uploads/images';
        $relFolder  = ltrim(str_replace($imagesRoot, '', $folderPath), '/\\');

        $files = UploadedFile::getInstancesByName('imageFiles');
        if (empty($files)) {
            return ['error' => 'Nessun file ricevuto.'];
        }

        $allowed     = ['jpg', 'jpeg', 'png', 'webp', 'avif', 'gif'];
        $folderSlug  = str_replace('/', '_', $relFolder); // es. "gara_sprint_roma"
        $previews    = [];
        $configs     = [];

        foreach ($files as $file) {
            if (!in_array(strtolower($file->extension), $allowed, true)) {
                continue;
            }

            // --- 1. Converti in WebP (salva temporaneamente in $imagesRoot con nome time_basename) ---
            $img                = new Image();
            $img->img_show_name = $file->baseName;

            try {
                $img->uploadSingleImage($file, null, 'webp');
            } catch (\Exception $e) {
                continue;
            }

            $tempBasename = $img->img_name;      // es. "1734567890_myfile"
            $ext          = $img->img_extension; // es. ".webp"
            $tempSource   = $imagesRoot . '/' . $tempBasename . $ext;

            // --- 2. Primo save per ottenere l'ID ---
            if (!$img->save()) {
                @unlink($tempSource);
                continue;
            }

            // --- 3. Nome definitivo: {id}_{folder_slug} ---
            $finalBasename = $img->id . '_' . $folderSlug; // es. "42_gara_sprint_roma"
            $targetPath    = $folderPath . '/' . $finalBasename . $ext;

            if (!rename($tempSource, $targetPath)) {
                $img->delete();
                continue;
            }

            // --- 4. Aggiorna img_name e img_show_name con percorso e nome definitivi ---
            $img->img_name      = $relFolder . '/' . $finalBasename;
            $img->img_show_name = str_replace('_', ' ', $finalBasename);

            if (!$img->save()) {
                @unlink($targetPath);
                $img->delete();
                continue;
            }

            // --- 5. Crea il collegamento in gara_foto ---
            $garaFoto           = new GaraFoto();
            $garaFoto->gara_id  = $gara_id;
            $garaFoto->image_id = $img->id;

            if (!$garaFoto->save()) {
                @unlink($targetPath);
                $img->delete();
                continue;
            }

            // --- 6. Risposta JSON per kartik FileInput ---
            $url        = rtrim(Yii::getAlias('@frontendUploads'), '/') . '/' . $relFolder . '/' . $finalBasename . $ext;
            $previews[] = $url;
            $configs[]  = [
                'type'    => 'image',
                'caption' => $file->baseName . $ext,
                'url'     => Url::to(['/foto-gara/delete-photo']),
                'key'     => $garaFoto->id,
                'extra'   => ['gara_id' => $gara_id],
            ];
        }

        if (empty($previews)) {
            return ['error' => 'Nessun file valido caricato.'];
        }

        return [
            'initialPreview'       => $previews,
            'initialPreviewConfig' => $configs,
            'append'               => true,
        ];
    }

    /**
     * Endpoint AJAX (kartik FileInput): elimina la foto da disco, dalla tabella
     * `image` e dal collegamento `gara_foto`.
     */
    public function actionDeletePhoto()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $gara_foto_id = (int) Yii::$app->request->post('key');
        $gara_id      = (int) Yii::$app->request->post('gara_id');

        $garaFoto = GaraFoto::findOne(['id' => $gara_foto_id, 'gara_id' => $gara_id]);
        if (!$garaFoto) {
            return ['error' => 'Record non trovato.'];
        }

        $img = $garaFoto->image;

        // Elimina file fisico
        if ($img) {
            $filePath = Yii::getAlias('@frontend') . '/web/uploads/images/'
                . $img->img_name . $img->img_extension;
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
            $img->delete(); // elimina dalla tabella image
        }

        $garaFoto->delete(); // elimina dalla tabella gara_foto

        return ['error' => '']; // kartik FileInput vuole error: '' per il successo
    }

    /**
     * Endpoint AJAX: importa tutte le immagini da una cartella sul server.
     * Replica la pipeline di actionUpload ma legge i file già presenti su disco.
     */
    public function actionImportFolder()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $gara_id    = (int) Yii::$app->request->post('gara_id');
        $sourcePath = trim(Yii::$app->request->post('folder_path', ''));

        $node = Gara::findOne($gara_id);
        if (!$node || !$node->isLeaf()) {
            return ['error' => 'Categoria non valida o non è una foglia.'];
        }

        if (!$sourcePath || !is_dir($sourcePath)) {
            return ['error' => 'Cartella non trovata: ' . $sourcePath];
        }

        $allowed    = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $files      = FileHelper::findFiles($sourcePath, [
            'only'      => array_map(fn($e) => "*.$e", $allowed),
            'recursive' => false,
        ]);

        if (empty($files)) {
            return ['error' => 'Nessuna immagine trovata nella cartella.'];
        }

        $folderPath  = $node->getFolderPath();
        FileHelper::createDirectory($folderPath, 0755, true);

        $imagesRoot = Yii::getAlias('@frontend') . '/web/uploads/images';
        $relFolder  = ltrim(str_replace($imagesRoot, '', $folderPath), '/\\');
        $folderSlug = str_replace('/', '_', $relFolder);

        $imported = 0;
        $skipped  = 0;
        $errors   = [];

        foreach ($files as $filePath) {
            $result = $this->importFileFromDisk($filePath, $gara_id, $folderPath, $relFolder, $folderSlug);
            if ($result === true) {
                $imported++;
            } elseif ($result === false) {
                $skipped++;
            } else {
                $errors[] = basename($filePath) . ': ' . $result;
            }
        }

        return [
            'imported' => $imported,
            'skipped'  => $skipped,
            'errors'   => $errors,
            'total'    => GaraFoto::findByGara($gara_id)->count(),
        ];
    }

    /**
     * Converte e importa un singolo file da disco nella gara.
     * Ritorna true, false (già importato/saltato), o una stringa di errore.
     */
    private function importFileFromDisk(
        string $filePath,
        int    $gara_id,
        string $folderPath,
        string $relFolder,
        string $folderSlug
    ): bool|string {
        $ext      = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $baseName = pathinfo($filePath, PATHINFO_FILENAME);

        // Legge il tipo reale dal file (non dall'estensione)
        $imageType = @exif_imagetype($filePath);
        if (!$imageType) {
            return 'Tipo file non riconosciuto.';
        }

        // Carica la risorsa GD
        $image = match ($imageType) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($filePath),
            IMAGETYPE_PNG  => (function () use ($filePath) {
                $im = imagecreatefrompng($filePath);
                imagepalettetotruecolor($im);
                imagealphablending($im, true);
                imagesavealpha($im, true);
                return $im;
            })(),
            IMAGETYPE_GIF  => (function () use ($filePath) {
                $im = imagecreatefromgif($filePath);
                imagepalettetotruecolor($im);
                imagealphablending($im, true);
                imagesavealpha($im, true);
                return $im;
            })(),
            IMAGETYPE_WEBP => imagecreatefromwebp($filePath),
            default        => null,
        };

        if (!$image) {
            return 'Impossibile leggere l\'immagine.';
        }

        // Salva temporaneamente come WebP nell'imagesRoot
        $imagesRoot  = Yii::getAlias('@frontend') . '/web/uploads/images';
        $tempBasename = time() . '_' . preg_replace('/[^a-z0-9_\-]/i', '_', $baseName);
        $tempPath    = $imagesRoot . '/' . $tempBasename . '.webp';

        if (!imagewebp($image, $tempPath, 80)) {
            imagedestroy($image);
            return 'Errore conversione WebP.';
        }
        imagedestroy($image);

        // Crea il record Image
        $img                = new Image();
        $img->img_show_name = $baseName;
        $img->img_name      = $tempBasename;
        $img->img_extension = '.webp';

        list($w, $h) = getimagesize($tempPath);
        $img->img_width        = $w;
        $img->img_height       = $h;
        $img->img_content_size = filesize($tempPath);
        $img->img_content_type = 'image/webp';

        if (!$img->save()) {
            @unlink($tempPath);
            return 'Errore salvataggio record Image.';
        }

        // Sposta nel percorso definitivo
        $finalBasename = $img->id . '_' . $folderSlug;
        $targetPath    = $folderPath . '/' . $finalBasename . '.webp';

        if (!rename($tempPath, $targetPath)) {
            $img->delete();
            return 'Errore spostamento file.';
        }

        $img->img_name      = $relFolder . '/' . $finalBasename;
        $img->img_show_name = str_replace('_', ' ', $finalBasename);
        if (!$img->save()) {
            @unlink($targetPath);
            $img->delete();
            return 'Errore aggiornamento record Image.';
        }

        // Crea il collegamento GaraFoto
        $garaFoto           = new GaraFoto();
        $garaFoto->gara_id  = $gara_id;
        $garaFoto->image_id = $img->id;

        if (!$garaFoto->save()) {
            @unlink($targetPath);
            $img->delete();
            return 'Errore salvataggio GaraFoto.';
        }

        return true;
    }

    /**
     * Endpoint AJAX GET: elenca sottocartelle di un percorso server.
     */
    public function actionListFolder($path = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $current = $path ? realpath($path) : realpath(Yii::getAlias('@frontend') . '/web/uploads');

        if (!$current || !is_dir($current)) {
            return ['error' => 'Percorso non valido.'];
        }

        $parent = dirname($current);
        $dirs   = [];
        $images = 0;

        foreach (scandir($current) as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }
            $full = $current . DIRECTORY_SEPARATOR . $item;
            if (is_dir($full)) {
                $dirs[] = ['name' => $item, 'path' => $full];
            } elseif (preg_match('/\.(jpe?g|png|webp|gif|avif)$/i', $item)) {
                $images++;
            }
        }

        return [
            'current' => $current,
            'parent'  => $parent !== $current ? $parent : null,
            'dirs'    => $dirs,
            'images'  => $images,
        ];
    }

    // ── Helpers privati ───────────────────────────────────────────────────────

    /**
     * Costruisce [id => 'percorso / nome'] per le sole foglie dell'albero.
     */
    private function buildLeafOptions(): array
    {
        $nodes = Gara::find()->orderBy(['root' => SORT_ASC, 'lft' => SORT_ASC])->all();
        if (empty($nodes)) {
            return [];
        }

        $paths = [];
        foreach ($nodes as $node) {
            $parts = [];
            foreach ($nodes as $candidate) {
                if ($candidate->root == $node->root
                    && $candidate->lft <= $node->lft
                    && $candidate->rgt >= $node->rgt
                    && $candidate->id !== $node->id
                ) {
                    $parts[] = $candidate->name;
                }
            }
            $parts[]          = $node->name;
            $paths[$node->id] = implode(' / ', $parts);
        }

        $options = [];
        foreach ($nodes as $node) {
            if ($node->isLeaf()) {
                $options[$node->id] = $paths[$node->id];
            }
        }

        return $options;
    }

}

