<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class TacheController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for tache
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Tache", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $tache = Tache::find($parameters);
        if (count($tache) == 0) {
            $this->flash->notice("The search did not find any tache");

            return $this->dispatcher->forward(array(
                "controller" => "tache",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $tache,
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
     * Edits a tache
     *
     * @param string $id
     */
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $tache = Tache::findFirstByid($id);
            if (!$tache) {
                $this->flash->error("tache was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "tache",
                    "action" => "index"
                ));
            }

            $this->view->id = $tache->id;

            $this->tag->setDefault("id", $tache->id);
            $this->tag->setDefault("libelle", $tache->libelle);
            $this->tag->setDefault("date", $tache->date);
            $this->tag->setDefault("avancement", $tache->avancement);
            $this->tag->setDefault("codeUseCase", $tache->codeUseCase);
            
        }
    }

    /**
     * Creates a new tache
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "tache",
                "action" => "index"
            ));
        }

        $tache = new Tache();

        $tache->libelle = $this->request->getPost("libelle");
        $tache->date = $this->request->getPost("date");
        $tache->avancement = $this->request->getPost("avancement");
        $tache->codeUseCase = $this->request->getPost("codeUseCase");
        

        if (!$tache->save()) {
            foreach ($tache->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tache",
                "action" => "new"
            ));
        }

        $this->flash->success("tache was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "tache",
            "action" => "index"
        ));

    }

    /**
     * Saves a tache edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "tache",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $tache = Tache::findFirstByid($id);
        if (!$tache) {
            $this->flash->error("tache does not exist " . $id);

            return $this->dispatcher->forward(array(
                "controller" => "tache",
                "action" => "index"
            ));
        }

        $tache->libelle = $this->request->getPost("libelle");
        $tache->date = $this->request->getPost("date");
        $tache->avancement = $this->request->getPost("avancement");
        $tache->codeUseCase = $this->request->getPost("codeUseCase");
        

        if (!$tache->save()) {

            foreach ($tache->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tache",
                "action" => "edit",
                "params" => array($tache->id)
            ));
        }

        $this->flash->success("tache was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "tache",
            "action" => "index"
        ));

    }

    /**
     * Deletes a tache
     *
     * @param string $id
     */
    public function deleteAction($id)
    {

        $tache = Tache::findFirstByid($id);
        if (!$tache) {
            $this->flash->error("tache was not found");

            return $this->dispatcher->forward(array(
                "controller" => "tache",
                "action" => "index"
            ));
        }

        if (!$tache->delete()) {

            foreach ($tache->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tache",
                "action" => "search"
            ));
        }

        $this->flash->success("tache was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "tache",
            "action" => "index"
        ));
    }

}
