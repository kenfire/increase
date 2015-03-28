<?php
/**
 * Created by PhpStorm.
 * User: kenzo
 * Date: 25/03/2015
 * Time: 11:23
 */

use Phalcon\Mvc\View;

class AuthorController extends ControllerBase
{
    public function projectsAction($id)
    {
        $author = User::findFirstByid($id);
        $this->view->author = $author; // variable accessible dans la vue

        // liste de tout les id des projets aux quels à participer le développeur
        $phql = "SELECT DISTINCT (idProjet)  FROM user where idDev = $id ORDER BY idPorjet";

        $idProjets = $this->modelsManager->executeQuery($phql);
        // liste de tout les projets

        $k=0;
        foreach ($idProjets as $id) {
            $project = Projet::findFirst(array(
                "id = $id"
            ));
            $projects[$k] = $project;
            $k++;
        }
        $this->view->projects = $projects;
        $i = 0;
        foreach ($projects as $project) {
            // Transformation en chiffre (% d'avancement - % du temps écoulé)
            $tmps = $project->getAvancement() -
                strtotime($project->getTempsRestant()->format('%R%d')) / strtotime($project->getTempsTotal()->format('%R%d'));

            // Class par défaut
            $class[$i] = "progress-bar progress-bar-striped active ";

            // Changement de la couleur de la bar de progression
            $reste = strtotime($project->getTempsRestant()->format('%R%a days'));

            if (strtotime($reste) < 0) { // dateFinPrevue dépassée
                $class[$i] = "progress-bar progress-bar-danger progress-bar-striped active ";
            } elseif ($tmps >= 0) {
                $class[$i] = "progress-bar progress-bar-success progress-bar-striped active ";
            } else {
                $class[$i] = "progress-bar progress-bar-warning progress-bar-striped active ";
            }

            //Bouton ouvrir d'un projet
            $j = $i + 1;
            $this->jquery->getAndBindTo("#btnOuvrir$j", "click", "user/project/" . $j . "/", "#response");

            $i++;
        }
        $this->view->class = $class;
        // Envoit du JS à la vue
        $this->jquery->compile($this->view);


    }

    public function projectAction($idProjet, $idAuthor)
    {
        $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);

        $projet = Projet::findFirst($idProjet);

        if ($projet != false) {
            if ($idAuthor != 0) {
                $usecases = $projet->getUsecases();
            } else{
                $projet = "noUser";
            }
        } else{
            $projet = "noProjet";
        }

        $this->view->projet = $projet;
        $this->view->usecases = $usecases;
        $this->view->author = $idAuthor;

        $this->view->nom = $projet->getNom();
        $this->view->user = $projet->getUser()->getIdentite();

        $this->view->description = $projet->getDescription();
        $this->view->dateLancement = $projet->getDateLancement();
        $this->view->dateFinPrevue = $projet->getDateFinPrevue();

        $this->jquery->get("project/author/".$idProjet."/".$idAuthor, "#detailProject");
        $this->jquery->compile($this->view);

    }
}
