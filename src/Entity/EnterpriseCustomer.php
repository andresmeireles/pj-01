<?php 
namespace App\Entity;

/**
* @Entity
* @Table(name="EnterpriseCustomer")
*/
class EnterpriseCustomer extends Customer
{
	/**
	 * @Column(type="string", length=15)
	 */
	public $customerCnpj;

	/**
	 * @Column(type="string")
	 */
	public $customerStateSubscription;

	/**
	 * @Column(type="string", nullable=true)
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

	/** @Column(type="integer", length=2, nullable=true) */
    public $customerEnterpriseNumberDdd;

    /** @Column(type="float", length=10) */
    public $customerEnterpriseNumber;
}