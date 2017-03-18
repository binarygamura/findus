<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace findus\modules\menu;

/**
 * Description of ManagementModule
 *
 * @author binary gamura
 */
class ManagementModule implements \findus\common\Module {
    
    public function execute() {
        $templateResponse = new \findus\common\TemplateResponse();
        $templateResponse->addTemplateName('management.htpl');
        return $templateResponse;
    }
}
