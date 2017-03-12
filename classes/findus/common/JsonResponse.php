<?php

namespace findus\common;

/**
 * Description of JsonResponse
 *
 * @author binary gamura
 */
class JsonResponse extends Response {
    
    
    public function setJson($body){
        $this->setBody(json_encode($body));
    }
}
