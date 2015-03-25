<?php

class Message extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $objet;

    /**
     *
     * @var string
     */
    public $content;

    /**
     *
     * @var string
     */
    public $date;

    /**
     *
     * @var integer
     */
    public $idUser;

    /**
     *
     * @var integer
     */
    public $idProjet;

    /**
     *
     * @var integer
     */
    public $idFil;

    public function initialize()
    {
        $this->belongsTo("idUser", "User", "id");
    }

    public function getId(){
        return $this->id;
    }

    public function getObjet(){
        return $this->objet;
    }

    public function getContent(){
        return $this->content;
    }

    public function getDate(){
        return $this->date;
    }

    public function getIdUser(){
        return $this->idUser;
    }

    public function getIdProjet(){
        return $this->idProjet;
    }
}
