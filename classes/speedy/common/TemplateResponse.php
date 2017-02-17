<?php

namespace speedy\common;

/**
 * Subclass of the Response class to hold additional
 * field only needed by responsed which contain a template.
 *
 * @author binary
 */
class TemplateResponse extends Response {
    
    private $values = array();
    
    public function __construct() {
        parent::__construct();
    }
    
    public function setValue($key, $value){
        $this->values[$key] = $value;
    }
    
    function getValues() {
        return $this->values;
    }

    function getTemplateName() {
        return $this->values['sub_template'];
    }

    function setValues($values) {
        $this->values = $values;
    }

    function setTemplateName($templateName) {
        $this->values['sub_template'] = $templateName;
    }

}
