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

    
    public function canAccess(speedy\model\User $user, $module, $config){
        
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
    
    
    private function renderTopMenu(\speedy\model\User $user){
        $output = '<ul>';
        foreach($this->configuration['menu'] as $name => $topLevelMenu){
            if($user->isA($topLevelMenu['role'])){
                $output .= '<li><a href="?module='.$topLevelMenu['module'].'">'.$name.'</a></li>';
            }
        }
        return $output.'</ul>';
    }
    
    private function renderSideMenu(\speedy\model\User $user){
        $output = '<ul>';
    }
    
    /**
     * Send the Response, which in normal cases was produced by executing 
     * a Module on behalf of the user. It takes care of creating the template 
     * structure.
     * 
     * @param \speedy\common\Response $response
     */
    public function sendResponseToClient(Response $response, \speedy\model\User $user){
        
        http_response_code($response->getResponseCode());
        header("Content-Type", $response->getContentType());
                
        if($response instanceof TemplateResponse){
            $smarty = $this->createSmartyInstance();
            $values = $response->getValues();
            $values['title'] =  $this->configuration['general']['title'];
            $values['topMenu'] = $this->renderTopMenu($user);
            $values['user'] = $_SESSION['user']->box();
            foreach($values as $key => $value){
                $smarty->assign($key, $value);
            }
            $smarty->display("index.htpl");
        }
        else {
            http_response_code($response->getResponseCode());
            foreach($response->getHeaders() as $key => $value){
                header($key.":".$value);
            }
            if($response->getBody()){
                echo $response->getBody();
            }
        }
    }
}
