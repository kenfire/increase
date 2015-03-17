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
	 *@var string
	 */
	public $reste;

    /**
     *
     *@var integer
     */
	public $avancement;
	
    public function initialize(){
        $this->belongsTo("idClient","User","id");
        $this->hasMany("id", "Usecase", "idProjet",array("alias"=>"usecases"));
        $this->hasManyToMany("id", "Usecase", "idProjet", "idDev", "User", "id",array("alias"=>"users"));
    }

    public function getNom(){
        return $this->nom;
    }

    public function getDescription(){
        return $this->description;
    }

    public function getdateLancement(){
        return $this->dateLancement;
    }

    public function getdateFinPrevue(){
        return $this->dateFinPrevue;
    }

	public function afterFetch(){
        // Calcule date restante
		$datetime1 = new DateTime(date("d-m-Y"));
		$datetime2 = new DateTime($this->dateFinPrevue);
		$interval = $datetime1->diff($datetime2);

		$this->reste = $interval->format('%R%a days');

        // Calcule % avancement du projet
        $this->avancement = 60 ;
	}

}
