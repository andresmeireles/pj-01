<?php
namespace App\Entity\Mapper;

use \Doctrine\ORM\EntityManager;
use Respect\Validation\Validator as v;
use \App\Validation\ValidatorJson;
use \App\Entity\Customer;

class CustomerMapper implements MapperInterface
{
    private $em;
    private $validator;

    function __construct(EntityManager $em, ValidatorJson $validator)
    {
        $this->em = $em;
        $this->validator = $validator;
    }

    public function insertData($params)
    {
        dump($params);
        die();
        if (!$this->sanitizeParams($params)) {
            return $this->validator->failed();
        }        

        $entity = new Customer;
        extract($params);

        if (!$this->registerExists($cpf)) {
            return false;
        }

        $entity->setId($id);
        $entity->setCustomerFirstName($customerFirstName);
        $entity->setCustomerLastName($customerLastName);
        $entity->setCustomerCPF($customerCPF);
        $entity->setCustomerAddressRoad($customerAddressRoad);
        $entity->setCustomerAddressNeighborhood($customerAddressNeighborhood);
        $entity->setCustomerAddressZipcode($customerAddressZipcode);
        $entity->setCustomerAddressHouseNumber($customerAddressHouseNumber);
        $entity->setCustomerAddressComplement($customerAddressComplement);
        $entity->setCustomerCity($customerCity);
        $entity->setCustomerState($customerState);
        $entity->setCustomerEmail($customerEmail);
        $entity->setCustomerEmail2($customerEmail2);
        $entity->setCustomerEnterpriseNumber($customerEnterpriseNumber);
        $entity->setCustomerCellphoneNumber($customerCellphoneNumber);
        $entity->setCustomerNumber($customerNumber);
        $entity->setCustomerNumber2($customerNumber2);
    
        $this->em->persist($entity);
        $this->em->flush();

        return true;
    }
    
    public function updateData($id, $params){}
    
    public function removeData($id){}
    
    public function registerExists($param)
    {
        if ($this->em->getRepository(Customer::class)->findBy(array('customerCPF' => $param))) {
            return false;
        }

        return true;
    }

    public function getEntityItem(){}
    
    public function getEntityItems(){}
    
    public function sanitizeParams($params)
    {
        $validator = $this->validator->validate($params, [
            'customerFirstName' => v::notEmpty()->noWhitespace()->alpha(),
            'customerLastName' => v::notEmpty()->noWhitespace()->alpha(),
            'customerCPF' => v::notEmpty()->cpf(),
            'customerAddressRoad' => v::notEmpty(),
            'customerAddressHouseNumber' => v::notEmpty()->noWhitespace()->intVal(),
            'customerAddressNeighborhood' => v::optional(v::notEmpty()),
            'customerAddressZipcode' => v::notEmpty(),
            'customerAddressComplement' => v::optional(v::notEmpty()),
            'customerState' => v::optional(v::notEmpty()->alpha()),
            'customerCity' => v::optional(v::notEmpty()->alpha()),
            'customerEmail' => v::notEmpty()->email(),
            'customerEmail2' => v::optional(v::email()),
            'customerEnterprizeNumber' => v::notEmpty()->noWhitespace()/** ->createCustomValidation() for fone */,
            'customerCellphone' => v::notEmpty()->noWhitespace()/** ->createCustomValidation() for fone */,
            'customerNumber' => v::optional(v::notEmpty()->noWhitespace()),
            'customerNumber2' => v::optional(v::notEmpty()->noWhitespace()),
        ]);

        if ($validator->failed()) {
            return false;
        }

        return true;
    }
}