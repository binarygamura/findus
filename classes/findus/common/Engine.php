<?php
namespace findus\common;

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
    
    private function renderTopMenu(\findus\model\User $user){
        $output = '<ul>';
        if(!$user->isOnlyVisitor()){
            unset($this->configuration['menu']['Login']);
        }
        foreach($this->configuration['menu'] as $name => $topLevelMenu){
            if($user->isA($topLevelMenu['role'])){
                $output .= '<li><a href="?module='.$topLevelMenu['module'].'">'.$name.'</a></li>';
            }
        }
        return $output.'</ul>';
    }   
    
    private function renderSideMenu(\findus\model\User $user){
        $output = "";
        $currentModule = filter_input(INPUT_GET, 'module');
            
        foreach($this->configuration['menu'] as $name => $topLevelMenu){
            if($topLevelMenu['module'] == $currentModule && isset($topLevelMenu['menu']) && count($topLevelMenu['menu']) > 0){
                $output = '<ul>'; 
                foreach($topLevelMenu['menu'] as $title => $module){
                    $output .= '<li><a href="?module='.$topLevelMenu['module'].'&subModule='.$module.'">'.$title.'</a></li>';
                }
                $output .= '</ul>';
                break;
            }
        }
        return $output;
    }
    
    /**
     * Send the Response, which in normal cases was produced by executing 
     * a Module on behalf of the user. It takes care of creating the template 
     * structure.
     * 
     * @param \findus\common\Response $response
     */
    public function sendResponseToClient(Response $response, \findus\model\User $user){
        
        http_response_code($response->getResponseCode());
        header("Content-Type", $response->getContentType());
                
        if($response instanceof TemplateResponse){
            $smarty = $this->createSmartyInstance();
            $values = $response->getValues();
            $values['title'] =  $this->configuration['general']['title'];
            $values['topMenu'] = $this->renderTopMenu($user);
            $values['sideMenu'] = $this->renderSideMenu($user);
            $values['user'] = $_SESSION['user']->box();
            $values['bottom_scripts'] = $response->getBottomScripts();
            $values['top_scripts'] = $response->getTopScripts();            
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
