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
        $this->hasManyToMany("id", "Usecase", "idProjet", "idDev", "User", "id", array("alias" => "users"));
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getdateLancement()
    {
        return $this->dateLancement;
    }

    public function getdateFinPrevue()
    {
        return $this->dateFinPrevue;
    }

    public function afterFetch()
    {
        /*
         * Calcule date restante
        */
        $today = new DateTime(date("d-m-Y"));
        $fin = new DateTime($this->dateFinPrevue);
        $interval = $today->diff($fin);

        $this->reste = $interval->format('%R%a days');
        /*
         * Calcule temps du projet
        */
        $start = new DateTime($this->dateLancement);
        $fin = new DateTime($this->dateFinPrevue);
        $total = $fin->diff($start);

        /*
        * Calcule % avancement du projet
        */
        $usecases = $this->getUseCases();
        $diviseur = 0;
        $val = 0;
        foreach ($usecases as $usecase) {
            $diviseur = $diviseur + $usecase->poids;
            $val = $val + ($usecase->poids * $usecase->avancement);
        }
        $this->avancement = round($val / $diviseur, 2);
        /*
         * Calcule temps écoulé
        */
        $today = new DateTime(date("d-m-Y"));
        $begin = new DateTime($this->dateLancement);
        $interval2 = $begin->diff($today);

        // Transformation en chiffre (% d'avancement - % du temps écoulé)
        $tmps = $val / $diviseur -
        strtotime($interval2->format('%R%d'))/strtotime($total->format('%R%d'));

        // Class par défaut
        $this->class = "progress-bar progress-bar-striped active ";

        // Changement de la couleur de la bar de progression
        if (strtotime($this->reste) < 0) { // dateFinPrevue dépassée
            $this->class = "progress-bar progress-bar-danger progress-bar-striped active ";
        } elseif ($tmps >= 0) {
            $this->class = "progress-bar progress-bar-success progress-bar-striped active ";
        } else {
            $this->class = "progress-bar progress-bar-warning progress-bar-striped active ";
        }
    }
}
