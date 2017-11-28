<?php
namespace App\Entity;
/**
 * @Entity
 * @Table(name="description")
 */
class Description
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    public $id;

    /** @Column(length=140) */
    public $description;
}