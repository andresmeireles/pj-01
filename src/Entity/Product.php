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
    public $id;

    /**
     * @ManyToOne(targetEntity="App\Entity\Description")
     * @JoinColumn(name="description_id", referencedColumnName="id")
     */
    public $description;

    /**
     * @ManyToOne(targetEntity="App\Entity\Height")
     * @JoinColumn(name="height_id", referencedColumnName="id")
     */
    public $height;

    /** @Column(type="float") */
    public $price;
}