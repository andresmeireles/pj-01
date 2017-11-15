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
        $this->entity = 'App\Entity\Product';
    }
    
    public function insertData($params)
    {
        if (!$this->sanitizeParams($params)) {
            return $this->validator->failed(); 
        }
        
        $entity = new $this->entity;
        extract($params);
        
        if (!$this->registerExists($params)) {
            return false;
        }
        
        
        $height = $this->em->getRepository(Height::class)->find($height);
        $desc = $this->em->getRepository(Description::class)->find($model);
        
        $entity->setDescription($desc);
        $entity->setHeight($height);
        $entity->setPrice($price);
        
        $this->em->persist($entity);
        $this->em->flush();
        
        return true;
    }
    
    public function updateData($id, $params)
    {
        if (!$this->sanitizePrice($params)) {
            return $this->validator->failed(); 
        }

        $entity = $this->em->find(Product::class, $id);
        extract($params); // $price
        
        $entity->setPrice($price);
        $this->em->persist($entity);
        $this->em->flush();
        
        return true;
    }
    
    public function removeData($id)
    {
        $entity = $this->em->find(Product::class ,$id);
        
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
    
    public function getRegister(array $orderBy = null)
    {
        return $this->em->getRepository($this->entity)->findBy(array(), $orderBy); 
    }
    
    public function getSingleRegister($id)
    {   
        $entity = $this->em->find(Product::class, $id);
        
        $result = [
            'model' => $entity->getDescription(),
            'height' => $entity->getHeight(),
            'price' => number_format($entity->getPrice(), 2, ',', '.')
        ];
        
        return $result; 
    }
    
    public function registerExists($params)
    {
        extract($parans);
        $repository = $this->em->getRepository($this->entity);
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
        