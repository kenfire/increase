<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $this->tag->setTitle('Welcome');
        parent::initialize();
    }

}

