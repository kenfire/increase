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
	
	
	
	public function initialize(){
		$this->belongsTo("idClient","User","id");
	}

	public function afterFetch(){
		$datetime1 = new DateTime(date("d-m-Y"));
		$datetime2 = new DateTime($this->dateFinPrevue);
		$interval = $datetime1->diff($datetime2);

		$this->reste = $interval->format('%R%a days');
	}

}
