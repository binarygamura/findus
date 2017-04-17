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
 * Description of DeletePictureModule
 *
 * @author boreas
 */
class DeletePictureModule extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::USER;
    }

    public function execute() {
        $fileName = filter_input(INPUT_POST, "filename", FILTER_SANITIZE_STRING);
        if($fileName === false){
            throw new \findus\common\ModuleException("Es wurde kein Bildname angegeben.");
        }
        \findus\controller\ImageBundleController::deleteImageByFilename($fileName);
    }
}
