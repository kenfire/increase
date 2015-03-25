<?php

class Projet extends \Phalcon\Mvc\Model
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
    public $nom;

    /**
     *
     * @var string
     */
    public $description;

    /**
     *
     * @var string
     */
    public $dateLancement;

    /**
     *
     * @var string
     */
    public $dateFinPrevue;

    /**
     *
     * @var integer
     */
    public $idClient;

    /**
     *
     * @var string
     */
    public $reste;

    /**
     *
     * @var integer
     */
    public $avancement;

    public function initialize()
    {
        $this->belongsTo("idClient", "User", "id");
        $this->hasMany("id", "Usecase", "idProjet", array("alias" => "usecases"));
        $this->hasMany("id", "Message", "idProjet", array("alias" => "AllMessages"));
        $this->hasManyToMany("id", "Usecase", "idProjet", "idDev", "User", "id", array("alias" => "users"));
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDateLancement()
    {
        return $this->dateLancement;
    }

    public function getDateFinPrevue()
    {
        return $this->dateFinPrevue;
    }

    public function getIdClient()
    {
        return $this->idClient;
    }

    /*
    * Calcule temps du projet
    */
    public function getTempsTotal()
    {
        $start = new DateTime($this->getDateLancement());
        $fin = new DateTime($this->getDateFinPrevue());
        $total = $fin->diff($start);

        return $total;
    }

    /*
    * Calcule temps écoulé
    */
    public function getTempsEcoule()
    {
        $today = new DateTime(date("d-m-Y"));
        $begin = new DateTime($this->dateLancement);
        $interval = $begin->diff($today);

        return $interval;
    }

    /*
    * Calcule date restante
    */
    public function getTempsRestant()
    {
        $today = new DateTime(date("d-m-Y"));
        $fin = new DateTime($this->dateFinPrevue);
        $interval = $today->diff($fin);

        return $interval;
    }

    /*
    * Calcule % avancement du projet
    */
    public function getAvancement()
    {

        $usecases = $this->getUseCases();
        $diviseur = 0;
        $val = 0;
        foreach ($usecases as $usecase) {
            $diviseur = $diviseur + $usecase->poids;
            $val = $val + ($usecase->poids * $usecase->avancement);
        }
        $resultat = $val / $diviseur;

        return $resultat;
    }

    public function afterFetch()
    {
        $this->reste = $this->getTempsRestant()->format('%R%a days');
        $this->avancement = round($this->getAvancement(), 2);
    }

}
