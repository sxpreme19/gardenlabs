<?php
namespace backend\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model{

    /**
     * @var UploadedFile[]
     */

     public $imageFiles;

     public function rules(){
         return [
             [['imageFiles'], 'file','skipOnEmpty' => false, 'extensions' => 'png, jpg,jpeg', 'maxFiles' => 4],
         ];
     }

     public function upload(){
        $filenames = [];
        if ($this->validate()) {
            foreach ($this->imageFiles as $file) {
                $fileName = $file->baseName . '.' . $file->extension;
                $uploadPath = 'uploads/' . $fileName;
                if ($file->saveAs($uploadPath)) {
                    $filenames[] = $fileName;
                }
            }
            return $filenames;
        }
        return false;
     }
}
?>