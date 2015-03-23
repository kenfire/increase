<?php

class User extends \Phalcon\Mvc\Model
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
    public $mail;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $identite;

    /**
     *
     * @var string
     */
    public $role;

    public function initialize(){
        $this->hasMany("id","Projet","idClient",array("alias"=>"projets"));
        $this->hasMany("id","Usecase","idDev",array("alias"=>"usecases"));
        $this->hasManyToMany("id", "Usecase", "idDev", "idProjet", "Projet", "id", array("alias" => "projetsdevs"));
    }

    public function getNom(){
        return $this->identite;
    }

    public function getPourcentage($id){
        $user = $this->getUsecases();
        $poids = 0;
        foreach($user as $usecase){
            $poids = $poids + $usecase->getPoids();
        }
        return $poids;
    }

    public function getProjet(){
        $user = $this->getProjetsdevs();
        foreach($user as $projet){
            $nomprojet = $projet->getNom();
        }
        return $nomprojet;
    }

}
