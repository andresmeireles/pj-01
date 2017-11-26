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
    private $Codigo;
    
    /** @Column(type="string") */
    private $Nome;
    
    /** @Column(type="string") */
    private $Uf;
    
    public function toArray()
    {
        return get_object_vars($this);
    }
    
    public function getId()
    {
        return $this->Id;
    }
    
    public function getCodigo()
    {
        return $this->CodigoUf;
    }
    
    public function getNome()
    {
        return $this->Nome;
    }
    
    public function getUf()
    {
        return $this->Uf;
    }
        
    public function setCodigoUf($codig)
    {
        $this->CodigoUf = $codigo;
    }
    
    public function setNome($nome)
    {
        $this->Nome = $nome;
    }
    
    public function setUf($uf)
    {
        $this->Uf = $uf;
    }
}