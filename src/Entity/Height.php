<?php
namespace App\Entity;
/**
 * @Entity
 * @Table(name="height")
 */
class Height
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    private $id;

    /** @Column(type="float") */
    private $height;

    // return values of objets
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function getId() : string
    {
        return $this->id;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height) 
    {
        $this->height = $height;
    }

    public function __set($name, $value)
    {
        if ($name == 'Height') {
            $this->setHeight($value);
        }
    }
}