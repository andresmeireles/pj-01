<?php
namespace App\Entity\Mapper;

use \Doctrine\ORM\EntityManager;
use Respect\Validation\Validator as v;
use \App\Validation\ValidatorJson;
use \App\Entity\Product;
use \App\Entity\Height;
use \App\Entity\Description;

class ProductMapper implements MapperInterface
{
    private $em;
    private $validator;
    private $entity;
    
    function __construct(EntityManager $em, ValidatorJson $validator = null)
    {
        $this->em = $em;
        $this->validator = $validator;
    }
    
    public function insert($params)
    {
        $em = $this->em;
        $entity = new Product();

        if ($this->sanitizeParams($params)) {
            return $this->validator->failed(); 
        }
        
        if (!$this->registerExists($params)) {
            return false;
        }
        
        try {
            $this->insertData($entity, $params, $em);

            $em->persist($entity);
            $em->flush();   

            return true;
        } catch (\Exception $e) {
            $error['msg'] = $e->getMessage();
            return $error;
        }
    }

    public function update($id, $params)
    {
        if (!$this->sanitizePrice($params)) {
            return $this->validator->failed(); 
        }

        $entity = $this->em->find(Product::class, $id);

        try {
            $this->insertData($entity, $params, $em);

            $this->em->merge($entity);
            $this->em->flush();    

            return true;
        } catch (Exception $e) {
            $error['msg'] = $e->getMessage();
            return $error;
        }
    }

    public function insertData($entity, array $params,EntityManager $em)
    {
        extract($params);

        $height = $em->getRepository(Height::class)->find($height);
        $desc = $em->getRepository(Description::class)->find($model);
        
        $entity->description = $desc;
        $entity->height = $height;
        $entity->price = $price;

        return $entity;
    }
    
    public function remove($id)
    {
        $entity = $this->em->find(Product::class ,$id);
        
        $connection = $this->em->getConnection(); 
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
    
    public function getRegister(array $orderBy = null)
    {
        return $this->em->getRepository(Product::class)->findBy(array(), $orderBy); 
    }
    
    public function getSingleRegister($id)
    {   
        $entity = $this->em->find(Product::class, $id);
        
        $result = [
            'model' => $entity->description,
            'height' => $entity->height,
            'price' => number_format($entity->price, 2, ',', '.')
        ];
        
        return $result; 
    }
    
    public function registerExists($params)
    {
        extract($parans);
        $repository = $this->em->getRepository(Product::class);
        if ($repository->findBy(array('height' => $height, 'description' => $model))) {
            return false;
        }

        return true;
    }
    
    public function sanitizeParams($params) {
        $validator = $this->validator->validate($params, [
            'model' => v::noWhitespace()->length(1, null),
            'height' => v::noWhitespace()->numeric()->length(1, null),
            'price' => v::nowhitespace()->numeric()->length(3, null),
        ]);

        if ($validator->failed()) {
            return false;
        }

        return true;
    }

    public function sanitizePrice($price) {
        $validator = $this->validator->validate($price, [
            'price' => v::noWhitespace()->numeric()->length(3, null),
        ]);

        if ($validator->failed()) {
            return false;
        }

        return true;
    }
}
