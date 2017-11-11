<?php
namespace App\Entity\Mapper;

interface MapperInterface
{
    public function insertData($parans);

    public function updateData($id, $params);
    
    public function removeData($id);

    //public function registerExists();
    //public function getEntityItem();

    //public function getEntityItems();

    //public function sanitizeParams($params);
}