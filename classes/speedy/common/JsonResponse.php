<?php

namespace speedy\common;

/**
 * Description of JsonResponse
 *
 * @author boreas
 */
class JsonResponse extends Response {
    
    
    public function setJson($body){
        $this->setBody(json_encode($body));
    }
}
