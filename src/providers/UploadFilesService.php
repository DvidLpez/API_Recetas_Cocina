<?php

namespace App\Providers;

class UploadFilesService {
    /**
     * Create path to send image user
     */
    public function createPathImagesUser($id)
    {
        $path = __DIR__ . '/../../images/'. $id .'/';
        if(!is_dir($path)){
            mkdir($path, 0777, true);
            chmod($path, 0777);
        }
        return $path;
    }
    /**
     * Create path to send image recipes
     */
    public function createPathRecipeImagesUser($id, $id_recipe)
    {
        $path = __DIR__ . '/../../images/'. $id .'/recipes/' . $id_recipe . '/';
        if(!is_dir($path)){
            mkdir($path, 0777, true);
            chmod($path, 0777);
        }
        return $path;
    }
    /**
     * Check if file sended is an image
     */
    public function checkImage($file) 
    {
        $type =  $file->getClientMediaType();
        $size =  $file->getSize();
        if(($type == 'image/png' || $type == 'image/jpg') && $size < '10000') { // size en bytes 1000 +- 1kb
            return true;
        }
        return false; 
    }
    /**
     * Check if file sended is an image
     */
    public function checkImages($files) 
    { 
        $i = count($files);
        $counter = 0;
        foreach ($files as $file) {
            $valid = UploadFilesService::checkImage($file);
            if($valid) {
                $counter++;
            }   
        }
        if($counter !== $i) {
            return false;
        }
        return true;        
    }
    /**
     * Move file to directory
     */
    public function moveUploadedFile($directory, $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
        $filename = sprintf('%s.%0.8s', $basename, $extension);
        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
        return $filename;
    }
}
