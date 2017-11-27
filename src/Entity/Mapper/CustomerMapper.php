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
        if (!$this->sanitizeParams($params)) {
            return $this->validator->failed();
        }        

        $entity = new Customer;
        extract($params);

        if (!$this->registerExists($cpf)) {
            return false;
        }

        try {

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
            $entity->setCustomerNumber($customerNumber == '' ? null : $customerNumber);
            $entity->setCustomerNumber2($customerNumber2 == '' ? null : $customerNumber2);
    
            $this->em->persist($entity);
            $this->em->flush();
        } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
            $error['msg'] = $e->getMessage();
            $error['error'] = 'Cpf ja esta cadastrado';
            return $error;
        }
        

        return true;
    }
    
    public function getRegister(array $query)
    {
        $em = $this->em;

        $repository = $em->getRepository('\App\Entity\Municipios');
        $privateResult = $repository->findBy($query);

        $publicResult = array_map(function ($a) {
            $result[$a->getId()] = $a->getNome();
            return $result;
        }, $privateResult);

        return $publicResult;
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
            'customerFirstName' => v::stringType()->notEmpty()->noWhitespace()->not(v::numeric()),
            'customerLastName' => v::stringType()->notEmpty()->not(v::numeric()),
            'customerCPF' => v::notEmpty()->cpf(),
            'customerAddressRoad' => v::notEmpty(),
            'customerAddressHouseNumber' => v::notEmpty(),
            'customerAddressNeighborhood' => v::optional(v::notEmpty()),
            'customerAddressZipcode' => v::notEmpty(),
            'customerAddressComplement' => v::optional(v::notEmpty()),
            'customerState' => v::optional(v::numeric()->notEmpty()->noWhitespace()),
            'customerCity' => v::optional(v::numeric()->notEmpty()->noWhitespace()),
            'customerEmail' => v::notEmpty()->email(),
            'customerEmail2' => v::optional(v::email()),
            'customerEnterpriseNumber' => v::notEmpty()->noWhitespace()/** ->createCustomValidation() for fone */,
            'customerCellphoneNumber' => v::notEmpty()->noWhitespace()/** ->createCustomValidation() for fone */,
            'customerNumber' => v::optional(v::notEmpty()->noWhitespace()),
            'customerNumber2' => v::optional(v::notEmpty()->noWhitespace()),
        ]);

        if ($validator->failed()) {
            return false;
        }

        return true;
    }
}