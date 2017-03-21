<?php

/*
 * Copyright 2017 binary gamura.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace findus\modules\animal;

/**
 * Description of UploadPictureModule
 *
 * @author binary gamura
 */
class UploadPictureModule extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::USER;
    }
    
    public function execute() {
        
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
        
        return new \findus\common\JsonResponse(["name" => $destination]);
    }
}
