<?php
namespace App\Entity\Mapper;

use \Doctrine\ORM\EntityManager;
use Respect\Validation\Validator as v;
use \App\Validation\ValidatorJson;

class DescriptionMapper implements MapperInterface
{
    private $em;
    private $validator;
    private $entity;
    
    function __construct(EntityManager $entityManager,ValidatorJson $validator = null)
    {
        $this->em = $entityManager;
        $this->validator = $validator;
        $this->entity = '\App\Entity\Description';
    }
    
    public function insert($params)
    {
        if ($this->sanitizeParams($params)) {
            $this->validator->failed();
        }

        $entity = new $this->entity;
        extract($params);

        // normalize description
        $description = strtoupper($description);

        if (!$this->registerExists($description)) {
            return false;
        }
        
        $entity->description = $description;
        
        $this->em->persist($entity);
        $this->em->flush();
        
        return true;
    }
    
    public function update($id, $params)
    {
        if (!$this->registerExists($params)) {
            return false;
        }
        
        if ($this->sanitizeParams()) {
            $this->validator->failed();
        }

        extract($params);
        $em = $this->em;
        $entity = $em->find('\App\Entity\Description', $id);

        $entity->setDescription($description);
        $em->persist($entity);
        $em->flush();

        return true;
    }
    
    public function insertData($entity,array $params,EntityManager $em)
    {
        
    }

    public function remove($id)
    {
        $entity = $this->em->find('\App\Entity\Description', $id);
        $connection = $this->em; 
        $connection->beginTransaction();
        
        try {
            $this->em->remove($entity);
            $this->em->flush();
        } catch (\Exception $e) {
            return $connection->rollback();
        }
        $connection->commit();
        
        return true;
    }

    public function getSingleRegister($id){}
    
    public function getRegister(array $orderBy = null)
    {
        return $this->em->getRepository($this->entity)->findBy(array(), $orderBy); 
    }

    public function sanitizeParams($params)
    {
        $validator = $this->validator->validate($params, [
            'height' => v::noWhitespace()->length(2, 4)
        ]);

        if ($validator->failed()) {
            return true;
        }

        return false;
    }
    
    private function registerExists($param)
    {
        if ($this->em->getRepository($this->entity)->findBy(array('description' => $param))) {
            return false;
        }

        return true;
    }
}