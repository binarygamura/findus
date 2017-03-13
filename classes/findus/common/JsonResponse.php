<?php

namespace findus\common;

/**
 * Description of JsonResponse
 *
 * @author binary gamura
 */
class JsonResponse extends Response {

    public function __construct($body = null, $status = 200){
        parent::__construct();
        $this->setJson($body);
        $this->setContentType("application/json");
        $this->setResponseCode($status);
    }
    
    public function setJson($body){
        $this->setBody(json_encode($body));
    }
}
