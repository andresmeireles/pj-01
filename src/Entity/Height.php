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
    public $id;

    /** @Column(type="float") */
    public $height;
}