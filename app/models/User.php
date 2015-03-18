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
    }

    public function getNom(){
        return $this->identite;
    }
}
