<?php

namespace findus\common;

/**
 * Subclass of the Response class to hold additional
 * field only needed by responsed which contain a template.
 *
 * @author binary
 */
class TemplateResponse extends Response {
    
    private $values = [];
    
    private $bottomScripts = [];
    
    private $topScripts = [];
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getBottomScripts() {
        return $this->bottomScripts;
    }
    
    function getTopScripts() {
        return $this->topScripts;
    }

    public function addScript($script, $bottom = true){
        $bottom ? $this->bottomScripts[] = $script : $this->topScripts = $script;
    }
    
    
    public function setValue($key, $value){
        $this->values[$key] = $value;
    }
    
    function getValues() {
        return $this->values;
    }

    function getTemplateNames() {
        return $this->values['templates'];
    }

    function setValues(array $values) {
        $this->values = $values;
    }

    function addTemplateName($templateName) {
        $this->values['templates'][] = $templateName;
    }

}
