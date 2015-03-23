<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected function initialize()
    {
        $this->tag->prependTitle('INCREASE | ');
        $this->view->setVar("jquery", $this->jquery->genCDNs("humanity"));//humanity template file for JqueryUI
    }

}
