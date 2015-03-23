<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\View;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ProjectController extends ControllerBase
{
    public function equipeAction($id)
    {
        $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);
        $projet = Projet::findFirst($id);

        $devs = [];
        $poidsDevs = [];
        $poidsProjet;
        foreach($projet->getUsecases() as $usecases){
            if (!in_array($usecases->getUser(), $devs)){
                $devs.array_push($devs, $usecases->getUser());
            }
            $poidsDevs[$usecases->getUser()->getId()] += $usecases->getPoids();
            $poidsProjet += $usecases->getPoids();
        }

        $this->view->devs = $devs;

        for($i=0; $i<sizeof($poidsDevs); $i++)
        {
            $poidsDevs[$i] = round ($poidsDevs[$i] / $poidsProjet * 100, 0);
        }

        $this->view->poidsDevs = $poidsDevs;

    }
    public function messagesAction()
    {

    }
}