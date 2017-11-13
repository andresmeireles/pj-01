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
    private $id;
    
    /** @Column(type="float") */
    private $CodigoUf;
    
    /** @Column(type="string") */
    private $Nome;
    
    /** @Column(type="string") */
    private $Uf;
    
    /** @Column(type="float") */
    private $Regiao;
    
    public function toArray()
    {
        return get_object_vars($this);
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getCodigoUf()
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
    
    public function getRegiao()
    {
        return $this->Regiao;
    }
    
    public function setCodigoUf($codigUf)
    {
        $this->CodigoUf = $codigoUf;
    }
    
    public function setNome($nome)
    {
        $this->Nome = $nome;
    }
    
    public function setUf($uf)
    {
        $this->Uf = $uf;
    }
    
    public function setRegiao($regiao)
    {
        $this->Regiao = $regiao;
    }
}