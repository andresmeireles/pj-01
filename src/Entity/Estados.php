<?php
namespace App\Entity;
/**
* @Entity
* @Table(name="Estado")
*/
class Estados 
{
    /**
    * @Id
    * @GeneratedValue(strategy="AUTO")
    * @Column(type="integer")
    */
    public $Id;
    
    /** @Column(type="float") */
    public $CodigoUf;
    
    /** @Column(type="string") */
    public $Nome;
    
    /** @Column(type="string") */
    public $Uf;
    
    /** @Column(type="float") */
    public $Regiao;
}