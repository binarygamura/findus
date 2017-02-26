<?php

namespace speedy\common;

/**
 * Description of Response
 *
 * @author binary
 */
class Response {
    
    private $responseCode;
    
    private $body;
    
    private $contentType = "application/json";
    
    private $useTemplating;
    
    private $templateName;
    
    private $pageTitle;
    
    private $headers = array();
    
    public function __construct() {
        $this->responseCode = ResponseCode::STATUS_OKAY;
    }
    
    public function getHeaders(){
        return $this->headers;
    }
    
    public function addHeader($key, $value){
        $this->headers[$key] = $value;
    }
    
    function getResponseCode() {
        return $this->responseCode;
    }

    function getResponseMessage() {
        return $this->responseMessage;
    }

    function getBody() {
        return $this->body;
    }

    function getUseTemplating() {
        return $this->useTemplating;
    }

    function getTemplateName() {
        return $this->templateName;
    }

    function getPageTitle() {
        return $this->pageTitle;
    }

    function setResponseCode($responseCode) {
        $this->responseCode = $responseCode;
    }

    function setResponseMessage($responseMessage) {
        $this->responseMessage = $responseMessage;
    }

    function setBody($body) {
        $this->body = $body;
    }

    function setUseTemplating($useTemplating) {
        $this->useTemplating = $useTemplating;
    }

    function setPageTitle($pageTitle) {
        $this->pageTitle = $pageTitle;
    }
    
    function getContentType() {
        return $this->contentType;
    }

    function setContentType($contentType) {
        $this->contentType = $contentType;
    }
}
