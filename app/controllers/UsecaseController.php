<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class UsecaseController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for usecase
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Usecase", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "code";

        $usecase = Usecase::find($parameters);
        if (count($usecase) == 0) {
            $this->flash->notice("The search did not find any usecase");

            return $this->dispatcher->forward(array(
                "controller" => "usecase",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $usecase,
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
     * Edits a usecase
     *
     * @param string $code
     */
    public function editAction($code)
    {

        if (!$this->request->isPost()) {

            $usecase = Usecase::findFirstBycode($code);
            if (!$usecase) {
                $this->flash->error("usecase was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "usecase",
                    "action" => "index"
                ));
            }

            $this->view->code = $usecase->code;

            $this->tag->setDefault("code", $usecase->code);
            $this->tag->setDefault("nom", $usecase->nom);
            $this->tag->setDefault("poids", $usecase->poids);
            $this->tag->setDefault("avancement", $usecase->avancement);
            $this->tag->setDefault("idProjet", $usecase->idProjet);
            $this->tag->setDefault("idDev", $usecase->idDev);
            
        }
    }

    /**
     * Creates a new usecase
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "usecase",
                "action" => "index"
            ));
        }

        $usecase = new Usecase();

        $usecase->code = $this->request->getPost("code");
        $usecase->nom = $this->request->getPost("nom");
        $usecase->poids = $this->request->getPost("poids");
        $usecase->avancement = $this->request->getPost("avancement");
        $usecase->idProjet = $this->request->getPost("idProjet");
        $usecase->idDev = $this->request->getPost("idDev");
        

        if (!$usecase->save()) {
            foreach ($usecase->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "usecase",
                "action" => "new"
            ));
        }

        $this->flash->success("usecase was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "usecase",
            "action" => "index"
        ));

    }

    /**
     * Saves a usecase edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "usecase",
                "action" => "index"
            ));
        }

        $code = $this->request->getPost("code");

        $usecase = Usecase::findFirstBycode($code);
        if (!$usecase) {
            $this->flash->error("usecase does not exist " . $code);

            return $this->dispatcher->forward(array(
                "controller" => "usecase",
                "action" => "index"
            ));
        }

        $usecase->code = $this->request->getPost("code");
        $usecase->nom = $this->request->getPost("nom");
        $usecase->poids = $this->request->getPost("poids");
        $usecase->avancement = $this->request->getPost("avancement");
        $usecase->idProjet = $this->request->getPost("idProjet");
        $usecase->idDev = $this->request->getPost("idDev");
        

        if (!$usecase->save()) {

            foreach ($usecase->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "usecase",
                "action" => "edit",
                "params" => array($usecase->code)
            ));
        }

        $this->flash->success("usecase was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "usecase",
            "action" => "index"
        ));

    }

    /**
     * Deletes a usecase
     *
     * @param string $code
     */
    public function deleteAction($code)
    {

        $usecase = Usecase::findFirstBycode($code);
        if (!$usecase) {
            $this->flash->error("usecase was not found");

            return $this->dispatcher->forward(array(
                "controller" => "usecase",
                "action" => "index"
            ));
        }

        if (!$usecase->delete()) {

            foreach ($usecase->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "usecase",
                "action" => "search"
            ));
        }

        $this->flash->success("usecase was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "usecase",
            "action" => "index"
        ));
    }

}
