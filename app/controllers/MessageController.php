<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class MessageController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for message
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Message", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $message = Message::find($parameters);
        if (count($message) == 0) {
            $this->flash->notice("The search did not find any message");

            return $this->dispatcher->forward(array(
                "controller" => "message",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $message,
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
     * Edits a message
     *
     * @param string $id
     */
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $message = Message::findFirstByid($id);
            if (!$message) {
                $this->flash->error("message was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "message",
                    "action" => "index"
                ));
            }

            $this->view->id = $message->id;

            $this->tag->setDefault("id", $message->id);
            $this->tag->setDefault("objet", $message->objet);
            $this->tag->setDefault("content", $message->content);
            $this->tag->setDefault("date", $message->date);
            $this->tag->setDefault("idUser", $message->idUser);
            $this->tag->setDefault("idProjet", $message->idProjet);
            $this->tag->setDefault("idFil", $message->idFil);
            
        }
    }

    /**
     * Creates a new message
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "message",
                "action" => "index"
            ));
        }

        $message = new Message();

        $message->objet = $this->request->getPost("objet");
        $message->content = $this->request->getPost("content");
        $message->date = $this->request->getPost("date");
        $message->idUser = $this->request->getPost("idUser");
        $message->idProjet = $this->request->getPost("idProjet");
        $message->idFil = $this->request->getPost("idFil");
        

        if (!$message->save()) {
            foreach ($message->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "message",
                "action" => "new"
            ));
        }

        $this->flash->success("message was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "message",
            "action" => "index"
        ));

    }

    /**
     * Saves a message edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "message",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $message = Message::findFirstByid($id);
        if (!$message) {
            $this->flash->error("message does not exist " . $id);

            return $this->dispatcher->forward(array(
                "controller" => "message",
                "action" => "index"
            ));
        }

        $message->objet = $this->request->getPost("objet");
        $message->content = $this->request->getPost("content");
        $message->date = $this->request->getPost("date");
        $message->idUser = $this->request->getPost("idUser");
        $message->idProjet = $this->request->getPost("idProjet");
        $message->idFil = $this->request->getPost("idFil");
        

        if (!$message->save()) {

            foreach ($message->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "message",
                "action" => "edit",
                "params" => array($message->id)
            ));
        }

        $this->flash->success("message was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "message",
            "action" => "index"
        ));

    }

    /**
     * Deletes a message
     *
     * @param string $id
     */
    public function deleteAction($id)
    {

        $message = Message::findFirstByid($id);
        if (!$message) {
            $this->flash->error("message was not found");

            return $this->dispatcher->forward(array(
                "controller" => "message",
                "action" => "index"
            ));
        }

        if (!$message->delete()) {

            foreach ($message->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "message",
                "action" => "search"
            ));
        }

        $this->flash->success("message was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "message",
            "action" => "index"
        ));
    }

}
