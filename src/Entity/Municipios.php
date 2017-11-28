<?php
namespace App\Entity;
/**
* @Entity
* @Table(name="Municipio")
*/
class Municipios 
{
    /**
    * @Id
    * @GeneratedValue(strategy="AUTO")
    * @Column(type="integer", name="Id")
    */
    public $Id;
    
    /** @Column(type="float") */
    public $Codigo;
    
    /** @Column(type="string") */
    public $Nome;
    
    /** @Column(type="string") */
    public $Uf;
}