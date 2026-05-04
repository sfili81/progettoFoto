<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use backend\models\Image;
use yii\validators\FileValidator;

class UploadFiles extends Model{
    /**
     * @var UploadedFile[]
    */
    public $imageFiles;
    public $previewImg;
    public $pdfFile;
    public $image_name_show;

    public function rules(){
        return [
            [['image_name_show',], 'string', 'max' => 255],
            [['imageFiles'], 'file','except' => ['update',], 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp', 'maxFiles' => 30,],//'uploadRequired '=>'Campo obbligatorio'
            [['imageFiles'], 'file', 'on' => ['update'], 'skipOnEmpty' => true, 'extensions' => 'png, jpg, webp', 'maxFiles' => 30, 'maxSize' => 1024 * 1024 * 2],
         
            [['previewImg'], 'required' , 'on' => ['showingCreate'] ], 
            [['previewImg'], 'file', 'extensions' => 'png, jpg, jpeg, webp', 'maxFiles' => 1,],

            [['pdfFile'],    'file', /*'skipOnEmpty' => true,*/ 'extensions' => 'pdf'],// non obbligatorio
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'image_name_show' => Yii::t('backend', 'Image Name Show'),
            'imageFiles'  => Yii::t('backend', 'Image Files'),
            'previewImg' => Yii::t('backend', 'Preview Img'),
        ];
    }
    
    /**
     * Upload multiplo di immagini
     *  viene creato un array con le seguenti proprietà<br>
     *  <ul>
     *      <li>name -> nome del file</li>
     *      <li>size -> dimensione dek file</li>
     *      <li>type -> tipo del file</li>
     *      <li>extension -> estensione del file</li>
     *      <li>folder -> cartella dove è stata caricata l'immagine</li>
     *  </ul>    
     *      
     *
     * @param string $dir è la cartella dove andranno salvate le immagini, di default è frontend/web/uploads/images/
     * 
     * @return bool|string Restituisce il nome dell'immagine se tutto è ok altrimenti restituisce la lista degli errori (false).
     * 
    */
    public function uploadImages( string $dir = "") : bool|array{
        $imagesUrl = array();

        //check if $dir isn't empty
        !empty($dir) ? $dir = $dir .'/' : '';

        if ($this->validate()) {     

            //prepare variable $path
            $path = Yii::getAlias('@frontend') .'/web/uploads/images/';
            //check and create dir
            //!is_dir($path) ? mkdir($path, 0777, true) : '';

            $imagesUrl['path'] = $path;
            $imagesUrl['listItem'] = array();

            foreach($this->imageFiles as $key => $file) {
                    
                $name = rand().'_'. str_replace('/', '',$dir) .'_'. $file->baseName;
                $path_img = $path;
                $path_img .=  $name . '.' . $file->extension;
                    
                $temp['ord']      = $key;
                $temp['name']      = $name;
                $temp['size']      = $file->size;
                $temp['type']      = $file->type;
                $temp['extension'] = $file->extension;  
                $temp['folder']    = $dir;  

                $file->saveAs($path_img);

                // array_push($imagesUrl, $file->baseName . '.' . $file->extension);
                array_push($imagesUrl['listItem'], $temp);
            }
            //Debug: exit;
            return $imagesUrl;
        } else {    
            var_dump($this->getErrors());            
            return false;
        }
    }


    /**
     * Upload di una singola immagine nella tabella Image
     *
     * @param string $dir è la cartella dove andranno salvate le immagini, di default è empty
     * 
     * @return bool|int Restituisce l'id dell'immagine salvata se tutto è ok altrimenti restituisce la lista degli errori (false).
     * 
    */
    public function uploadSingleImage( ?string $preview_tag, string $dir = "") : bool|int{

        $img_model = new Image();

        if ($this->validate()) {

            //prepare variable $path
            $path = Yii::getAlias('@frontend') .'/web/uploads/images/';
            $preview_tag ? $preview_tag = $preview_tag.'_' : $preview_tag = '';
              
            $name = rand().'_'.$preview_tag. $this->previewImg->baseName. '.' . $this->previewImg->extension;

            $path_img = $path;
            $path_img .=  $name;

            $img_model = new Image();

            //Save data on Image Model
            list($width, $height) = getimagesize($this->previewImg->tempName);
            $img_model->img_show_name  = $this->image_name_show;
            $img_model->img_name =  $name;
            $img_model->img_extension = $this->previewImg->extension;
            $img_model->img_width = $width;
            $img_model->img_height = $height;
            $img_model->img_content_size = $this->previewImg->size;
            $img_model->img_content_type = $this->previewImg->type;
        
            try{            
                $this->previewImg->saveAs($path_img);
                $img_model->save();        
            }catch(yii\base\UserException $e){
                echo $e->getName(); 
            }
            return $img_model->id;
        } else {  
            var_dump($this->getErrors());            
            return false;
        }
    }
    
    /**
     * [Description for uploadPdf]
     *
     * @param string $dir
     * 
     * @return bool|string
     * 
     */
    public function uploadPdf() : bool|string{
        $pdf = $this->pdfFile;
        
        /* NB capire bene dove presenta problemi qui */  
        if ($this->validate()) {
                $name = rand().'_'. $pdf->baseName;
   
                $dir = Yii::getAlias('@frontend') .'/web/uploads/pdf/';
                $path = $dir .$name. '.' . $pdf->extension;
                $pdf->saveAs($path, false);
                return $name;
        }else{
            var_dump($this->getErrors());
            return false;
        }           
    }    

}// end class