<?php
namespace App\Entity;

/**
 * @Entity
 * @Table(name="customers")
 */
class Customer
{
     /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    private $id;
    
    /** @Column(type="string") */
    private $customerFirstName;
    
    /** @Column(type="string") */
    private $customerLastName;
    
    /** @Column(type="integer", length=11, unique=true) */
    private $customerCPF;

    /** @Column(type="string") */
    private $customerAddressRoad;

    /** @Column(type="string") */
    private $customerAddressNeighborhood;

    /** @Column(type="string") */
    private $customerAddressZipcode;

    /** @Column(type="string") */
    private $customerAddressHouseNumber;

    /** @Column(type="string", nullable=true) */
    private $customerAddressComplement;

    /** @Column(type="integer", nullable=true) */
    private $customerCity;

    /** @Column(type="integer") */
    private $customerState;

    /** @Column(type="string") */
    private $customerEmail;

    /** @Column(type="string", nullable=true) */
    private $customerEmail2;

    /** @Column(type="integer", length=10) */
    private $customerEnterpriseNumber;

    /** @Column(type="integer", length=11) */
    private $customerCellphoneNumber;

    /** @Column(type="integer", length=11, nullable=true) */
    private $customerNumber;

    /** @Column(type="integer", length=11, nullable=true) */
    private $customerNumber2;
    
    function getId() {
        return $this->id;
    }

    function getCustomerFirstName() {
        return $this->customerFirstName;
    }

    function getCustomerLastName() {
        return $this->customerLastName;
    }

    function getCustomerCPF() {
        return $this->customerCPF;
    }

    function getCustomerAddressRoad() {
        return $this->customerAddressRoad;
    }

    function getCustomerAddressNeighborhood() {
        return $this->customerAddressNeighborhood;
    }

    function getCustomerAddressZipcode() {
        return $this->customerAddressZipcode;
    }

    function getCustomerAddressHouseNumber() {
        return $this->customerAddressHouseNumber;
    }

    function getCustomerAddressComplement() {
        return $this->customerAddressComplement;
    }

    function getCustomerCity() {
        return $this->customerCity;
    }

    function getCustomerState() {
        return $this->customerState;
    }

    function getCustomerEmail() {
        return $this->customerEmail;
    }

    function getCustomerEmail2() {
        return $this->customerEmail2;
    }

    function getCustomerEnterpriseNumber() {
        return $this->customerEnterpriseNumber;
    }

    function getCustomerCellphoneNumber() {
        return $this->customerCellphoneNumber;
    }

    function getCustomerNumber() {
        return $this->customerNumber;
    }

    function getCustomerNumber2() {
        return $this->customerNumber2;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCustomerFirstName($customerFirstName) {
        $this->customerFirstName = $customerFirstName;
    }

    function setCustomerLastName($customerLastName) {
        $this->customerLastName = $customerLastName;
    }

    function setCustomerCPF($customerCPF) {
        $this->customerCPF = $customerCPF;
    }

    function setCustomerAddressRoad($customerAddressRoad) {
        $this->customerAddressRoad = $customerAddressRoad;
    }

    function setCustomerAddressNeighborhood($customerAddressNeighborhood) {
        $this->customerAddressNeighborhood = $customerAddressNeighborhood;
    }

    function setCustomerAddressZipcode($customerAddressZipcode) {
        $this->customerAddressZipcode = $customerAddressZipcode;
    }

    function setCustomerAddressHouseNumber($customerAddressHouseNumber) {
        $this->customerAddressHouseNumber = $customerAddressHouseNumber;
    }

    function setCustomerAddressComplement($customerAddressComplement) {
        $this->customerAddressComplement = $customerAddressComplement;
    }

    function setCustomerCity($customerCity) {
        $this->customerCity = $customerCity;
    }

    function setCustomerState($customerState) {
        $this->customerState = $customerState;
    }

    function setCustomerEmail($customerEmail) {
        $this->customerEmail = $customerEmail;
    }

    function setCustomerEmail2($customerEmail2) {
        $this->customerEmail2 = $customerEmail2;
    }

    function setCustomerEnterpriseNumber($customerEnterpriseNumber) {
        $this->customerEnterpriseNumber = $customerEnterpriseNumber;
    }

    function setCustomerCellphoneNumber($customerCellphoneNumber) {
        $this->customerCellphoneNumber = $customerCellphoneNumber;
    }

    function setCustomerNumber($customerNumber) {
        $this->customerNumber = $customerNumber;
    }

    function setCustomerNumber2($customerNumber2) {
        $this->customerNumber2 = $customerNumber2;
    }
}
