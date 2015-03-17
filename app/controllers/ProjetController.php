<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ProjetController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for projet
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Projet", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $projet = Projet::find($parameters);
        if (count($projet) == 0) {
            $this->flash->notice("The search did not find any projet");

            return $this->dispatcher->forward(array(
                "controller" => "projet",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $projet,
            "limit"=> 10,
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
     * Edits a projet
     *
     * @param string $id
     */
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $projet = Projet::findFirstByid($id);
            if (!$projet) {
                $this->flash->error("projet was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "projet",
                    "action" => "index"
                ));
            }

            $this->view->id = $projet->id;

            $this->tag->setDefault("id", $projet->id);
            $this->tag->setDefault("nom", $projet->nom);
            $this->tag->setDefault("description", $projet->description);
            $this->tag->setDefault("dateLancement", $projet->dateLancement);
            $this->tag->setDefault("dateFinPrevue", $projet->dateFinPrevue);
            $this->tag->setDefault("idClient", $projet->idClient);
            
        }
    }

    /**
     * Creates a new projet
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "projet",
                "action" => "index"
            ));
        }

        $projet = new Projet();

        $projet->nom = $this->request->getPost("nom");
        $projet->description = $this->request->getPost("description");
        $projet->dateLancement = $this->request->getPost("dateLancement");
        $projet->dateFinPrevue = $this->request->getPost("dateFinPrevue");
        $projet->idClient = $this->request->getPost("idClient");
        

        if (!$projet->save()) {
            foreach ($projet->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "projet",
                "action" => "new"
            ));
        }

        $this->flash->success("projet was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "projet",
            "action" => "index"
        ));

    }

    /**
     * Saves a projet edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "projet",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $projet = Projet::findFirstByid($id);
        if (!$projet) {
            $this->flash->error("projet does not exist " . $id);

            return $this->dispatcher->forward(array(
                "controller" => "projet",
                "action" => "index"
            ));
        }

        $projet->nom = $this->request->getPost("nom");
        $projet->description = $this->request->getPost("description");
        $projet->dateLancement = $this->request->getPost("dateLancement");
        $projet->dateFinPrevue = $this->request->getPost("dateFinPrevue");
        $projet->idClient = $this->request->getPost("idClient");
        

        if (!$projet->save()) {

            foreach ($projet->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "projet",
                "action" => "edit",
                "params" => array($projet->id)
            ));
        }

        $this->flash->success("projet was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "projet",
            "action" => "index"
        ));

    }

    /**
     * Deletes a projet
     *
     * @param string $id
     */
    public function deleteAction($id)
    {

        $projet = Projet::findFirstByid($id);
        if (!$projet) {
            $this->flash->error("projet was not found");

            return $this->dispatcher->forward(array(
                "controller" => "projet",
                "action" => "index"
            ));
        }

        if (!$projet->delete()) {

            foreach ($projet->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "projet",
                "action" => "search"
            ));
        }

        $this->flash->success("projet was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "projet",
            "action" => "index"
        ));
    }

}
