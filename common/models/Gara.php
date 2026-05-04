<?php
namespace common\models;

use Yii;

class Gara extends \kartik\tree\models\Tree
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gara';
    }

    /**
     * Override isDisabled method if you need as shown in the
     * example below. You can override similarly other methods
     * like isActive, isMovable etc.
     */
    public function isDisabled()
    {
        $identity = Yii::$app->user->identity;
        if ($identity === null || $identity->username !== 'admin') {
            return true;
        }
        return parent::isDisabled();
    }

    /**
     * Crea automaticamente la cartella in frontend/web/uploads/images/{percorso_gerarchico}
     * ogni volta che viene inserito un nuovo nodo.
     * Esempio: gara → images/gara, gara/roma → images/gara/roma
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            $path = $this->buildFolderPath();
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }
        }
    }

    /**
     * Restituisce il percorso assoluto della cartella upload per questo nodo.
     */
    public function getFolderPath(): string
    {
        return $this->buildFolderPath();
    }

    /**
     * Costruisce il percorso assoluto della cartella rispecchiando la gerarchia dell'albero.
     */
    private function buildFolderPath()
    {
        $basePath = Yii::getAlias('@frontend') . '/web/uploads/images';

        // Recupera gli antenati ordinati dal root al padre diretto
        $ancestors = $this->parents()->orderBy('lft')->all();

        $parts = [];
        foreach ($ancestors as $ancestor) {
            $parts[] = $this->sanitizeFolderName($ancestor->name);
        }
        $parts[] = $this->sanitizeFolderName($this->name);

        return $basePath . '/' . implode('/', $parts);
    }

    /**
     * Normalizza il nome del nodo per l'uso come nome di cartella:
     * minuscolo, spazi → underscore, rimuove caratteri non sicuri per filesystem.
     */
    private function sanitizeFolderName($name)
    {
        $name = mb_strtolower(trim($name), 'UTF-8');
        $name = preg_replace('/\s+/', '_', $name);
        $name = preg_replace('/[\/\\\:\*\?"<>\|]/', '', $name);
        return $name ?: 'nodo';
    }
}