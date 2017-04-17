<?php

namespace findus\controller;

use \RedBeanPHP\R;

/**
 * Description of ImageBundleController
 *
 * @author binary
 */
class ImageBundleController {
    
    public static function getBundleById($bundleId){
        return R::findOne("imagebundle", "id = ?", $bundleId);
    }
    
    public static function deleteImageByFilename($fileName){
        $image = R::findOne("image", "name = ?", [$fileName]);
        if($image == NULL){
            throw new ControllerException("Das angegebene Bild konnte nicht gefunden werden.");
        }
        R::trash($image);
        $directoryOfApplication = dirname(filter_input(INPUT_SERVER, 'SCRIPT_FILENAME' ));
        unlink($directoryOfApplication."/images/portraits/",$fileName);
    }

    public static function addUploadToImageBundle($bundleId){
        
        if(!isset($_FILES['file']) || !isset($_FILES['file']['name']) || $_FILES['file']['size'] == 0){
            throw new \findus\common\ModuleException("no image data to upload!".print_r($_FILES, true));
        }
        if(isset($_FILES['file']['error']) && ($_FILES['file']['error'] != 0)){
            throw new \findus\common\ModuleException($_FILES['file']['error']);
        }
        
        $fileName = $_FILES['file']['name'];
        $tmpFileName = $_FILES['file']['tmp_name'];
        $fileExtension = ".".pathinfo($fileName, PATHINFO_EXTENSION);
        
        //get the basepath of the application. this is where the index.php lives.
        $directoryOfApplication = dirname(filter_input(INPUT_SERVER, 'SCRIPT_FILENAME' ));
        
        //get unique filename within the portraits directory.
        $destination = \findus\common\Util::getUniqueFilename($directoryOfApplication."/images/portraits", $fileExtension);
        if(!$destination){
            throw new \findus\common\ModuleException("unable to determine unique file!");
        }
        $absoluteDestination = $directoryOfApplication."/images/portraits/".$destination;
        
        if(!move_uploaded_file($tmpFileName, $absoluteDestination)){
            throw new \findus\common\ModuleException("unable to store file in \"".$absoluteDestination."\"");
        }
        
        if($bundleId){
            $bundle = R::findOne("imagebundle", "id = ?" , [$bundleId]);
        }
        else {
            $bundle = R::dispense("imagebundle");
            $bundle->portrait = "";
        }
        
        $image = R::dispense("image");
        $image->name = $destination;
        $image->isPortrait = false;
        R::store($image);
        
        $bundle->ownImageList[] = $image;
        R::store($bundle);
        
        $bundle = R::findOne("imagebundle","id = ?", [$bundle->id]);
        count($bundle->ownImageList);
        return $bundle;
    }    
}
