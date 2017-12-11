<?php
namespace App\Entity\Mapper;

use \Doctrine\ORM\EntityManager;

interface MapperInterface
{
	public function insert($params);

    public function update($id, $params);
    
    public function remove($id);

    public function insertData($entity, array $params,EntityManager $em);

    public function getSingleRegister($id);

    //public function getEntityItem();

    //public function getEntityItems();

    //public function sanitizeParams($params);
}