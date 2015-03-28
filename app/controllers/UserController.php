<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\View;
use Phalcon\Paginator\Adapter\Model as Paginator;

class UserController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for user
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "User", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $user = User::find($parameters);
        if (count($user) == 0) {
            $this->flash->notice("The search did not find any user");

            return $this->dispatcher->forward(array(
                "controller" => "user",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $user,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displayes the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a user
     *
     * @param string $id
     */
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $user = User::findFirstByid($id);
            if (!$user) {
                $this->flash->error("user was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "user",
                    "action" => "index"
                ));
            }

            $this->view->id = $user->id;

            $this->tag->setDefault("id", $user->id);
            $this->tag->setDefault("mail", $user->mail);
            $this->tag->setDefault("password", $user->password);
            $this->tag->setDefault("identite", $user->identite);
            $this->tag->setDefault("role", $user->role);

        }
    }

    /**
     * Creates a new user
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "user",
                "action" => "index"
            ));
        }

        $user = new User();

        $user->mail = $this->request->getPost("mail");
        $user->password = $this->request->getPost("password");
        $user->identite = $this->request->getPost("identite");
        $user->role = $this->request->getPost("role");


        if (!$user->save()) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "user",
                "action" => "new"
            ));
        }

        $this->flash->success("user was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "user",
            "action" => "index"
        ));

    }

    /**
     * Saves a user edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "user",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $user = User::findFirstByid($id);
        if (!$user) {
            $this->flash->error("user does not exist " . $id);

            return $this->dispatcher->forward(array(
                "controller" => "user",
                "action" => "index"
            ));
        }

        $user->mail = $this->request->getPost("mail");
        $user->password = $this->request->getPost("password");
        $user->identite = $this->request->getPost("identite");
        $user->role = $this->request->getPost("role");


        if (!$user->save()) {

            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "user",
                "action" => "edit",
                "params" => array($user->id)
            ));
        }

        $this->flash->success("user was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "user",
            "action" => "index"
        ));

    }

    /**
     * Deletes a user
     *
     * @param string $id
     */
    public function deleteAction($id)
    {

        $user = User::findFirstByid($id);
        if (!$user) {
            $this->flash->error("user was not found");

            return $this->dispatcher->forward(array(
                "controller" => "user",
                "action" => "index"
            ));
        }

        if (!$user->delete()) {

            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "user",
                "action" => "search"
            ));
        }

        $this->flash->success("user was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "user",
            "action" => "index"
        ));
    }

    public function projectsAction($id)
    {
        $user = User::findFirstByid($id);
        $this->view->user = $user; // variable accessible dans la vue

        // liste de tout les projets
        $projects = Projet::find(array(
            "idClient = $id"
        ));

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
            $j = $i+1;
            $this->jquery->getAndBindTo("#btnOuvrir$j", "click", "user/project/".$j."/", "#response");

            $i++;
        }

        $this->view->projects = $projects;
        $this->view->class = $class;

        // Envoit du JS à la vue
        $this->jquery->compile($this->view);


    }

    public function projectAction($id)
    {
        $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);
        $projet = Projet::findFirst($id);

        $this->view->nom = $projet->getNom();
        $this->view->user = $projet->getUser()->getIdentite();

        $this->view->description = $projet->getDescription();
        $this->view->dateLancement = $projet->getDateLancement();
        $this->view->dateFinPrevue = $projet->getDateFinPrevue();

        $this->jquery->get("project/equipe/".$id, "#detailProject");
        $this->jquery->getAndBindTo("#btnMessages", "click", "project/messages/".$id, "#divMessages");
        $this->jquery->compile($this->view);

        $nbmessage = 0;

        foreach($projet->getAllMessages() as $nbmessage){
            $nbmessage += 1;
        }

        $this->view->nbmessage = $nbmessage;
    }
}
