<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace speedy\modules;

/**
 * Description of ManageRacesModule
 *
 * @author binary gamura
 */
class ManageRacesModule implements \speedy\common\Module {

    public function execute() {
        $response = new \speedy\common\TemplateResponse();
        $response->addTemplateName("manage_races.htpl");
        return $response;
    }

}
