<?php
namespace findus\common;

/**
 * Description of RedirectResponse
 *
 * @author binary
 */
class RedirectResponse extends Response {
    public function __construct($redirectLink) {
        parent::__construct();
        $this->setResponseCode(302);
        $this->addHeader("Location", $redirectLink);
    }
}
