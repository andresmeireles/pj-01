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
	private $id;

	/** @Column(type="integer") */
	private $day;

	/** @Column(type="integer") */
	private $month;

	/** @Column(type="integer") */
	private $year;

	/**
     * @ManyToOne(targetEntity="App\Entity\Product")
     * @JoinColumn(name="product_id", referencedColumnName="id")
     */
	private $product;

	/** @Column(type="integer") */
	private $amount;

	public function getArrayCopy()
    {
        return get_object_vars($this);
    }

	public function toArray()
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

	public function getDay()
	{
		return $this->day;
	}

	public function setDay($value)
	{
		$this->day = $value;
	}

	public function getMonth()
	{
		return $this->month;
	}

	public function setMonth($value)
	{
		$this->month = $value;
	}

	public function getYear()
	{
		return $this->year;
	}

	public function setYear($year)
	{
	    $this->year = $year;
	}

	public function getProduct()
	{
	    return $this->product->getProduct();
	}

	public function setProduct($product)
	{
	    $this->product = $product;
	}

	/**
	 * @return type
	 */
	public function getAmount()
	{
	    return $this->amount;
	}

	/**
	 * @param type $amount
	 */
	public function setAmount($amount)
	{
	    $this->amount = $amount;
	}
}