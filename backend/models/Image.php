<?php

namespace backend\models;

use Yii;
use common\models\Images;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property string $img_name
 * @property string|null $img_show_name
 * @property string|null $img_description
 * @property string $img_extension
 * @property int|null $img_width
 * @property int|null $img_height
 * @property string|null $img_content_type
 * @property int|null $img_content_size
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Block[] $blocks
 * @property News[] $news
 */
class Image extends Images
{

    /* Proprietà per immagini singole
       Se vogliamo aggiungere altre immagini singole da usare con kartik
       va aggiunta la relativa proprietà e aggiunte anche nelle rules
    */
    public $imageFile;      // immagine principale
    public $imageMobile;    // immagine mobile

    public $saveFormat = 'webp';
    public $quality = 60;
    public $_image;//field fo js cropper

    public function behaviors( ) {
	    return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at','updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],    
	    ];
	}

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules =  [
            [['_image','saveFormat'], 'safe'],//bs cropper

            [['imageFile', 'imageMobile'], 'file','except' => ['update',], 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp', ],//'uploadRequired '=>'Campo obbligatorio'
            [['imageFile', 'imageMobile'], 'file', 'on' => ['update'], 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp', 'maxSize' => 1024 * 1024 * 2],
        ];

        return array_merge($rules,parent::rules());
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $labels = [
            'saveWebp' => Yii::t('backend', 'Save WebP Format'),
            'saveAvif' => Yii::t('backend', 'Save Avif Format'),
        ];

        return array_merge($labels,parent::attributeLabels());
    }

    /**** Funzioni ****/

    /**
     * Upload di un singolo attributo immagine.
     */
    public function uploadAttributeImage(string $attribute, ?string $preview_tag = null, string $format = 'webp'): bool
    {
        $file = UploadedFile::getInstance($this, $attribute);

        if (!$file) {
            return false;
        }

        $this->imageFile = $file;

        try {
            $this->uploadSingleImage($this->imageFile, $preview_tag, $format);
            $this->save(false);
        } catch (\yii\base\UserException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            return false;
        }

        $this->$attribute = null;
        $this->imageFile = null;

        return true;
    }
    

    /**
     * Upload di una singola immagine nella tabella Image
     *
     * @param string $preview_tag [DISMESSO]
     * @param string $dir è la cartella dove andranno salvate le immagini, di default è empty
     * 
     * @return bool|int Restituisce l'id dell'immagine salvata se tutto è ok altrimenti restituisce la lista degli errori (false).
     * 
    */
    public function uploadSingleImage(?UploadedFile $imageHandler, ?string $preview_tag, string $format = 'original', string $dir = "") : void  {

        //prepare variable $path
        $path = Yii::getAlias('@frontend') .'/web/uploads/images/';
        $preview_tag ? $preview_tag = $preview_tag.'_' : $preview_tag = '';

        $filename = preg_replace('/\.\w+$/', '', $imageHandler->name);      
        $name = time().'_'.$filename ;//. $this->imageFile->baseName; 
        //$name .= rand(100000, 999999);  
        $this->img_name =  $name;

        //uso cropper.js
        if (is_string($this->_image) && strstr($this->_image, 'data:image')) {
            // creating image file as png, for example
            // cropper sends image data in a base64 encoded string
            $data = $this->_image;      
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
            dd($name);
            // Load GD resource from binary data.
            $im = imageCreateFromString($data);           
            //Set where to save image created                      
            switch($format){
                case 'original': $name .= '.png';break;
                case 'webp':$function = "imagewebp"; $name .= '.webp';break;
                case 'avif':$function = "imageavif"; $name .= '.avif';;break;
            }
            $output_path = $path . $name;
           
            if(isset($function)){
               call_user_func($function,$im, $output_path, $this->quality);
            }else{
                imagepng($im,$output_path);
            }            
            
            $this->setModelValues($output_path);
            
        }else if(!empty($imageHandler)){
        //uso upload normale
            //set path to save imag
            $path_img =  $path . $name. '.' . $imageHandler->extension;
            //chek if image is svg 
            $is_svg = str_contains($imageHandler->type , 'svg');
            //chek if image is already converted 
            $is_convertible = ( !$is_svg &&
                                !str_contains($imageHandler->type , 'webp') &&
                                !str_contains($imageHandler->type , 'avif') 
                            );
            if(isset($format) && $format != 'original' && $is_convertible){
                $this->convertImage($imageHandler,$format, $path, $name);
            }else{//save original image
                try{ 
                    //dd($path_img);    
                    $imageHandler->saveAs($path_img);
                    $is_svg ? $this->setModelValuesSvg($path_img) : $this->setModelValues($path_img);      
                }catch(yii\base\UserException $e){
                    echo $e->getName(); 
                }
            }
            //elimino le referenze visto che non mi servono piu
            $imageHandler = "";
            $this->imageFile = "";
        }


        /* QUESTO CODICE VA CONTROLLATO E MESSO DENTRO L'IF SE ESISTE UN FILe UPLOADATO

        $path_img = $path;
        $path_img .=  $name. '.' . $this->imageFile->extension;

        //set image name           
        $this->img_name =  $name;
        
        if(isset($format) && $format != 'original'){
            $this->convertImage($format, $path, $name);
        }else{//save original image
            try{     
                $this->imageFile->saveAs($path_img);
                $this->setModelValues($path_img); 
                //$img_model->save();        
            }catch(yii\base\UserException $e){
                echo $e->getName(); 
            }
        }*/
    }

    private function convertImage(UploadedFile $imageHandler, $format, $path, $name){

        switch($format){
            case 'webp':$function = "imagewebp";break;
            case 'avif':$function = "imageavif";break;
        }

        $fileType = exif_imagetype($imageHandler->tempName);

        switch ($fileType) {
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($imageHandler->tempName);
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                break;
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($imageHandler->tempName);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($imageHandler->tempName);
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                break;
            default:
                break;
        }

        //Set where to save image created
        $output_path = $path . $name . '.'. $format;
        call_user_func($function,$image, $output_path, $this->quality);
        $this->setModelValues($output_path);
    }

    /**
     *  
     */
    private function setModelValues($file) : void{
        list($width, $height, $imageType) = getimagesize($file);
        $this->img_extension = image_type_to_extension($imageType);
        $this->img_extension == '.jpeg' ? $this->img_extension = '.jpg' : '';
        $this->img_width = $width;
        $this->img_height = $height;
        $this->img_content_size =  filesize($file);
        $this->img_content_type = image_type_to_mime_type($imageType);
    }

}// End model
