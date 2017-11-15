<?php 
namespace App\Controller;

use App\Entity\Product;
use App\Entity\Production;
/**
* 
*/
class ProductionController extends Controller
{	
	public function index($request, $response)
	{
		$this->renderer->render($response, 'production_landing.twig');
	}

	public function addProduction($request, $response)
	{
		$products = $this->db->getRepository(Product::class)->findAll();
		$date = date('d/m/Y');

		$this->renderer->render($response, 'add_production.twig', [
			'prod' => $products,
			'date' => $date,
		]);
	}

	public function getProductJson($request, $response)
	{
		$product = $this->db->getRepository(Product::class)->findAll();

		$result = array_map(function ($product) {
			$res['id'] = $product->getId();
			$res['prod'] = $product->getDescription().' '.$product->getHeight();
			return $res;
		}, $product);

		return $response->withJson($result);
	}

	public function saveProduction($request, $response)
	{
		$models = $request->getParsedBodyParam('models');
		$amount = $request->getParsedBodyParam('amount');

		$date = $request->getParsedBodyParam('date');
		$date = explode('/', $date);
		$day = $date[0];
		$month = $date[1];
		$year = $date[2];

		$productionProducts = array_combine(array_values($models), array_values($amount));

		foreach ($productionProducts as $model => $amount) {
			$production = new Production;
			$product = $this->db->find(Product::class, $model);
			$production->setDay($day);
			$production->setMonth($month);
			$production->setYear($year);
			$production->setProduct($product);
			$production->setAmount($amount);
			$this->db->persist($production);
			$this->db->flush();
		}

		$this->db->flush();

		return $response->withJson(['success' => true]);
	}
}