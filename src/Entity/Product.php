<?php
namespace App\Entity;
/**
 * @Entity
 * @Table(name="product")
 */
class Product
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="App\Entity\Description")
     * @JoinColumn(name="description_id", referencedColumnName="id")
     */
    private $description;

    /**
     * @ManyToOne(targetEntity="App\Entity\Height")
     * @JoinColumn(name="height_id", referencedColumnName="id")
     */
    private $height;

    /** @Column(type="float") */
    private $price;

    public function toArray()
    {
        return get_object_vars($this);
    }

    public function ObjectToArray()
    {
        $data = array();

        foreach ($this as $value => $key) {
            $data[$value] = $key;
        }

        return $data;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDescription()
    {
        return $this->description->getDescription();
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getHeight()
    {
        return $this->height->getHeight();
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }
}