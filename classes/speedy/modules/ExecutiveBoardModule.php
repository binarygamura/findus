<?php
namespace speedy\modules;

/**
 * Description of ExecutiveBoardModule
 *
 * @author binary gamura
 */
class ExecutiveBoardModule {
    
        public function execute() {
        $response = new \speedy\common\TemplateResponse();
        $response->addTemplateName("executive_board.htpl");
        return $response;
    }
}
