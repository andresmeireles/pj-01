<?php 
namespace App\Entity;

/**
* @Entity
* @Table(name="EnterpriseCustomer")
*/
class EnterpriseCustomer extends Customer
{
	/**
	 * @Column(type="float", length=15)
	 */
	public $customerCnpj;

	/*
	 * @column(type="integer")
	 */
	public $customerStateSubscription;

	/*
	* @column(type="integer", nullable=true)
	 */
	public $customerMunicipalSubscription;

	/**
	 * @Column(type="string", nullable=true)
	 */
	public $customerFantasyName;

	/**
	 * @Column(type="string")
	 */
	public $customerSocialName;

    /** @Column(type="float", length=10) */
    public $customerEnterpriseNumber;
}