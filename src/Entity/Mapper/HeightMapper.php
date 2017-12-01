<?php
namespace App\Entity\Mapper;

use Doctrine\ORM\EntityManager;
use Respect\Validation\Validator as v;
use \App\Validation\ValidatorJson;

class HeightMapper implements MapperInterface
{
    protected $em;
    protected $validation;
    protected $entity;
    
    public function __construct(EntityManager $entityManager,ValidatorJson $validator = null)
    {
        $this->em = $entityManager;
        $this->validation = $validator;
        $this->entity = '\App\Entity\Height';
    }
    
    public function insertData($params)
    {
        $entity = new $this->entity;
        extract($params); // create height variable  

        //normalize height
        $height = str_pad($height, 4, 0, STR_PAD_RIGHT);
        
        if (!$this->registerExists($height)) {
            return false;
        }

        if ($this->sanitizeParams($params)) {
            return $this->validation->failed(); 
        }
        
        $entity->height = $height;
        $this->em->persist($entity);
        $this->em->flush();
        
        return true;
    }
    
    public function updateData($id, $params){}
        
    public function removeData($id)
    {
        $entity = $this->em->find('\App\Entity\Height', $id);
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
        $repository = $this->em->getRepository($this->entity)->findBy([], $orderBy);
        $result = array_map(function ($repository) {
            $result['id'] = $repository->id;
            $result['value'] = $repository->height;
            return $result;
        }, $repository);

        return $result; 
    }

    private function sanitizeParams($params)
    {
        $validator = $this->validation->validate($params, [
            'height' => v::noWhitespace()->numeric()->length(3, null)
        ]);

        if ($validator->failed()) {
            return true;
        }

        return false;
    }
        
    private function registerExists($param)
    {
        if ($this->em->getRepository($this->entity)->findBy(array('height' => $param))) {
            return false;
        }
            
        return true;
    }
}