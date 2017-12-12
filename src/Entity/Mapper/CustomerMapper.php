<?php
namespace App\Entity\Mapper;

use \Doctrine\ORM\EntityManager;
use Respect\Validation\Validator as v;
use \App\Validation\ValidatorJson;
use \App\Entity\EnterpriseCustomer;

class CustomerMapper implements MapperInterface
{
    private $em;
    private $validator;
    
    function __construct(EntityManager $em, ValidatorJson $validator)
    {
        $this->em = $em;
        $this->validator = $validator;
    }
    
    public function insert($params)
    {
        $em = $this->em;
        $entity = new EnterpriseCustomer;
        
        if (!$this->sanitizeParams($params)) {
            return $this->validator->failed();
        }        
        
        try {
            $this->insertData($entity, $params, $em);

            $em->persist($entity);
            $em->flush();
            
            return true;    
        } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
            $error['msg'] = $e->getMessage();
            $error['error'] = 'Cpf ja esta cadastrado';
            return $error;
        }
        
    }

    public function update($id, $params)
    {
        $em = $this->em;

        $entity = $em->find(EnterpriseCustomer::class, $id);
        
        if (!$this->sanitizeParams($params)) {
            return $this->validator->failed();
        }        

        try {

            $this->insertData($entity, $params, $em);
               
            $em->merge($entity);
            $em->flush();
            
            return true;    
        } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
            $error['msg'] = $e->getMessage();
            return $error;
        }
    }
    
    public function getRegister(array $query)
    {
        $em = $this->em;
        
        $repository = $em->getRepository('\App\Entity\Municipios');
        $result = $repository->findBy($query);
        
        return $result;
    }

    public function getSingleRegister($id)
    {
        $em = $this->em;

        try {
            if ($repository = $em->find('\App\Entity\EnterpriseCustomer', $id)) {
                return $repository;   
            }
            throw new \Exception('Cliente não existe');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function remove($id)
    {
        $em = $this->em;
        $result = '';

        $connection = $em->getConnection();
        $connection->beginTransaction();

        try {
            $entity = $em->find(EnterpriseCustomer::class, $id);
            $em->remove($entity);
            $em->flush();
            $result = true;
        } catch (\Exception $e) {
            $connection->rollback();
            $result = $e->getMessage();
        }

        $connection->commit();

        return $result;
    }

    public function registerExists($param)
    {
        if ($this->em->getRepository(EnterpriseCustomer::class)->findBy(array('customerCPF' => $param))) {
            return false;
        }

        return true;
    }

    public function sanitizeParams($params)
    {
        $validator = $this->validator->validate($params, [
            'customerFirstName' => v::stringType()->notEmpty()->noWhitespace()->not(v::numeric()),
            'customerLastName' => v::stringType()->notEmpty()->not(v::numeric()),
            'customerCPF' => v::notEmpty()->cpf(),
            'customerSocialName' => v::stringType()->notEmpty(),
            'customerFantasyName' => v::optional(v::stringType()),
            'customerCnpj' => v::numeric()->notEmpty()->noWhitespace(),//->CpfExists(),
            'customerStateSubscription' => v::numeric()->notEmpty()->noWhitespace(),
            'customerMunicipalSubscription' => v::numeric()->notEmpty()->noWhitespace(),
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

    public function insertData($entity,array $params,EntityManager $entityManager) 
    {
        $em = $entityManager;
        extract($params);

        $entity->customerFirstName = $customerFirstName;
        $entity->customerLastName =$customerLastName;
        $entity->customerCPF = $customerCPF;
        $entity->customerAddressRoad = $customerAddressRoad;
        $entity->customerAddressNeighborhood = $customerAddressNeighborhood;
        $entity->customerAddressZipcode = $customerAddressZipcode;
        $entity->customerAddressHouseNumber = $customerAddressHouseNumber;
        $entity->customerAddressComplement = $customerAddressComplement;
        $entity->customerCity = $em->find('\App\Entity\Municipios', $customerCity);
        $entity->customerState = $em->find('\App\Entity\Estados', $customerState);
        $entity->customerEmail = $customerEmail;
        $entity->customerEmail2 = $customerEmail2;
        $entity->customerEnterpriseNumber = $customerEnterpriseNumber;
        $entity->customerCellphoneNumber = $customerCellphoneNumber;
        $entity->customerNumber = ($customerNumber == '' ? null : $customerNumber);
        $entity->customerNumber2 = ($customerNumber2 == '' ? null : $customerNumber2);
        $entity->customerSocialName = $customerSocialName;
        $entity->customerFantasyName = $customerFantasyName;
        $entity->customerCnpj = $customerCnpj;
        $entity->customerStateSubscription = $customerStateSubscription;
        $entity->customerMunicipalSubscription = $customerMunicipalSubscription;

        return $entity;
    }
}