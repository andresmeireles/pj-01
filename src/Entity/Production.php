<?php
namespace App\Entity;
/**
 * @Entity
 * @Table(name="production")
 */
class Production
{
	/**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
    */
	public $id;

	/** @Column(type="integer") */
	public $day;

	/** @Column(type="integer") */
	public $month;

	/** @Column(type="integer") */
	public $year;

	/**
     * @ManyToOne(targetEntity="App\Entity\Product")
     * @JoinColumn(name="product_id", referencedColumnName="id")
     */
	public $product;

	/** @Column(type="integer") */
	public $amount;
}