<?php
namespace App\Controller;

use \App\Entity\Product;
use \Slim\Container;

class RecordController
{
    private $db;
    private $view;
    private $validator;

    function __construct(Container $container)
    {
        $this->db = $container->db;
        $this->view = $container->renderer;
        $this->validator = $container->validationJson;
    }

    public function __invoke($request, $response)
    {
        $prod = $this->db->getRepository(Product::class)->findAll();

        $this->view->render($response, 'record.twig', [
            'product' => $prod
        ]);
    }

    public function addProduct($request, $response)
    {
        $entity = str_rot13('product');
        $auxEntity = str_rot13('height');
        $productMapper = new \App\Entity\Mapper\ProductMapper($this->db);
        $descriptionMapper = new \App\Entity\Mapper\DescriptionMapper($this->db);
        $prod = $productMapper->getRegister(['description' => 'ASC']);
        $model = $descriptionMapper->getRegister(['description' => 'ASC']);

        $this->view->render($response, 'add_product.twig', [
            'product' => $prod,
            'model' => $model,
            'entity' => $entity,
            'auxEntity' => $auxEntity,
        ]);
    }

    //Customers part
    public function getCustomers($request, $response) 
    {
        $entity = str_rot13('customer');
        $customers = $this->db->getRepository('\App\Entity\Customer')->findAll();

        return $this->view->render($response, '/register/customers.twig', array(
            'entity' => $entity,
            'customers' => $customer,
        ));
    }
    
    public function addHeight($request, $response)
    {
        $height = $this->db->getRepository('App\Entity\Height')->findBy(array(), array('height' => 'DESC'));

        $entity = str_rot13('height');

        $this->view->render($response, 'add_height.twig', [
            'heights' => $height,
            'entity' => $entity
        ]);
    }

    public function desc($request, $response)
    {
        $description = $this->db->getRepository('App\Entity\Description')->findBy(array(), array('description' => 'ASC'));

        $entity = str_rot13('description');

        $this->view->render($response, 'add_description.twig', [
            'desc' => $description,
            'entity' => $entity
        ]);
    }

    public function insert($request, $response)
    {
        $params = $request->getParam('data');
        $mapper = $this->getMapperName($request->getParam('entity')); 
        return $response->withJson($mapper->insertData($params));
    }

    public function remove($request, $response)
    {
        $param = $request->getParam('id');
        $mapper = $this->getMapperName($request->getParam('entity'));
        return $response->withJson($mapper->removeData($param));
    }

    public function update($request, $response)
    {
        $mapper = $this->getMapperName($request->getParam('entity'));

        $params = $request->getParam('params');
        $id = $request->getParam('id');
        return $response->withJson($mapper->updateData($id, $params));
    }

    public function getSingleRegistry($request, $response, $args)
    {
        $entity = str_rot13($args['entity']);
        $class = '\App\Entity\Mapper\\'.ucwords($entity).'Mapper';
        $mapper = new $class($this->db);
        $id = $args['id'];
        return $response->withJson($mapper->getSingleRegister($id));
    }

    public function getRegistry($request, $response)
    {   
        $mapper = $this->getMapperName($request->getParam('entity')); 
        return $response->withJson($mapper->getRegister(['height' => 'ASC']));
    }

    private function getMapperName($entity)
    {
        $name = str_rot13($entity);
        $mapperName = "\App\Entity\Mapper\\".ucwords($name)."Mapper";
        return new $mapperName($this->db, $this->validator);
    }
}