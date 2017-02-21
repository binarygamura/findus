<?php

namespace speedy\common;

/**
 * Subclass of the Response class to hold additional
 * field only needed by responsed which contain a template.
 *
 * @author binary
 */
class TemplateResponse extends Response {
    
    private $values = [];
    
    public function __construct() {
        parent::__construct();
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
