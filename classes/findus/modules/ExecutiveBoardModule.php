<?php
namespace findus\modules;

/**
 * Description of ExecutiveBoardModule
 *
 * @author binary gamura
 */
class ExecutiveBoardModule {
    
        public function execute() {
        $response = new \findus\common\TemplateResponse();
        $response->addTemplateName("executive_board.htpl");
        return $response;
    }
}
