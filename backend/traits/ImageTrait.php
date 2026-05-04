<?php

namespace backend\traits;

use Yii;

trait ImageTrait {

    /*
    * Funziona che recupera i dati necessari a mostrare l'anteprima nel campo upload di immagini multiple
    * dell'estensione kartik
    */
    public function setPreviewMultipleImage( $images) : array{
        $config = array();
        $list = array();
        $initialPreviewConfig = array();
        if($images){
            $listImg = json_decode($images, true);
            $listImg['listItem'] = array_values($listImg['listItem']);
            // set the list of image 
            foreach($listImg['listItem'] as $key=>$img){
                $list[]=  Yii::getAlias('@frontendUploads') . "/".$img['name'] .'.'. $img['extension'] ;
                $initialPreviewConfig[] = (['key' => $key,'caption' => $img['name']]);
            }
        }
        $config['list'] = $list;
        $config['initialPreviewConfig'] = $initialPreviewConfig;
        return $config;
   }

   public function deleteImageFromAjax(Object $model, $request, $listImg ) : void {
        $key = $request['key'];
        if(strlen($key) > 0){
            //Delete file 
            $t = dirname(__DIR__,2) .Yii::getAlias('@frontendUploads') . "/".$listImg['listItem'][$key]['name'] .'.'. $listImg['listItem'][$key]['extension'] ;
            unlink($t);
            //Remove the image from listimg array and then save model
            unset($listImg['listItem'][$key]);
            $listImg['listItem'] = array_values($listImg['listItem']);
            $model->images = json_encode($listImg);
            $model->save();
        }
   }

   public function deleteSingleImageFromAjax(Object $model, string $imgName, string $property = 'id_image', string $type = 'desktop'  ) : void {
        //Delete file
        $t = dirname(__DIR__,2) .Yii::getAlias('@frontendUploads') . "/".$imgName ;
        unlink($t); 
        switch($type){
            case 'desktop': $model->$property = NULL;break;
            case 'mobile': $model->id_image_mob = NULL;break;
        }
        $model->save();           
    }

    public function reorderImages(Object $model, int $oldIndex, int $newIndex, array $listImg ) : void {
        $items = $listImg['listItem'];
        // Prendo l'elemento spostato
        $movedItem = $items[$oldIndex];
        // Rimuovo l'elemento
        array_splice($items, $oldIndex, 1);
        // Inserisco nella nuova posizione
        array_splice($items, $newIndex, 0, [$movedItem]);

        // Riassegno ord a TUTTI in base alla nuova posizione
        //&$item è una referenza all’elemento corrente, lavora direttamente sull’elemento originale dentro l’array, non su una sua copia.
        foreach ($items as $i => &$item) {
            $item['ord'] = $i;
        }
        unset($item);//rimuovo la referenza

        $listImg['listItem'] = $items;
        $model->images = json_encode($listImg);
        $model->save();
        
    }

}//end Trait

