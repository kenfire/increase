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

    public function getPoids(){
        return $this->poids;
    }

    public function getAvancement(){
        return $this->avancement;
    }

    public function getIdProjet(){
        return $this->idProjet;
    }

    public function getIdDev(){
        return $this->idDev;
    }

}
