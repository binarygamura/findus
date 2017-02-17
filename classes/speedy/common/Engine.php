<?php
namespace speedy\common;

/**
 * The engine is actually the heart of the application and should contain
 * most of the logic needed by this application.
 *
 * @author binary
 */
class Engine {
    
    private $configuration;
    
    function __construct(array $configuration) {
        $this->configuration = $configuration;
    }

    
    public function canAccess(speedy\common\User $user, $module, $config){
        
    }
    
    private function handleTemplateResponse($templateResponse){
        
    }
    
    /**
     * Create a preconfigured Smarty instance. Every caller gets his own instance,
     * no instance sharing oder lazy loading.
     * 
     * @return \Smarty
     */
    private function createSmartyInstance(){
        $smarty = new \Smarty();
        $smarty->setTemplateDir($this->configuration['templating']['templateDir']);
        $smarty->setCompileDir($this->configuration['templating']['compileDir']);
        return $smarty;
    }
    
    /**
     * Send the Response, which in normal cases was produced by executing 
     * a Module on behalf of the user. It takes care of creating the template 
     * structure.
     * 
     * @param \speedy\common\Response $response
     */
    public function sendResponseToClient(Response $response){
        
        http_response_code($response->getResponseCode());
        header("Content-Type", $response->getContentType());
                
        if($response instanceof TemplateResponse){
            $smarty = $this->createSmartyInstance();
            $values = $response->getValues();
            
            $values['sub_template'] = $response->getTemplateName();
            $smarty->display("index.htpl");
            echo "tet";
        }
        else {
            echo "tet";
            echo $response->getBody();
        }
    }
}
