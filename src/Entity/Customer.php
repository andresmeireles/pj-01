<?php
namespace App\Entity;

/**
 * @MappedSuperclass
 */
class Customer
{
     /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    public $id;
    
    /** @Column(type="string") */
    public $customerFirstName;
    
    /** @Column(type="string") */
    public $customerLastName;
    
    /** @Column(type="float", length=11, unique=true) */
    public $customerCPF;

    /** @Column(type="string") */
    public $customerAddressRoad;

    /** @Column(type="string") */
    public $customerAddressNeighborhood;

    /** @Column(type="string") */
    public $customerAddressZipcode;

    /** @Column(type="string") */
    public $customerAddressHouseNumber;

    /** @Column(type="string", nullable=true) */
    public $customerAddressComplement;

    /** 
     * @ManyToOne(targetEntity="App\Entity\Municipios")
     * @JoinColumn(name="customerCity", referencedColumnName="Id") 
     */
    public $customerCity;
 
    /** 
     * @ManyToOne(targetEntity="App\Entity\Estados")
     * @JoinColumn(name="customerState", referencedColumnName="Id")
     */
    public $customerState;

    /** @Column(type="string") */
    public $customerEmail;

    /** @Column(type="string", nullable=true) */
    public $customerEmail2;

    /** @Column(type="float", length=11) */
    public $customerCellphoneNumber;

    /** @Column(type="float", length=11, nullable=true) */
    public $customerNumber;

    /** @Column(type="float", length=11, nullable=true) */
    public $customerNumber2;
}
