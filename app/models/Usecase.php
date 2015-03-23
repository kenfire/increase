<?php

class Usecase extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     */
    public $code;

    /**
     *
     * @var string
     */
    public $nom;

    /**
     *
     * @var integer
     */
    public $poids;

    /**
     *
     * @var integer
     */
    public $avancement;

    /**
     *
     * @var integer
     */
    public $idProjet;

    /**
     *
     * @var integer
     */
    public $idDev;

    public function initialize(){
        $this->belongsTo("idDev","User","id");
        $this->belongsTo("idProjet","Projet","id");
    }

    public function getCode(){
        return $this->code;
    }
    public function getidDev(){
        return $this->idDev;
    }

    public function getPoids(){
        return $this->poids;
    }

    public function getidProjet(){
        return $this->idProjet;
    }

}
