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
    }

    public function getidDev(){
        return $this->idDev;
    }

    public function getPoids(){
        return $this->poids;
    }
}
