<?php 
namespace App\Controller\Auth;

use \App\Controller\Controller;
use Respect\Validation\Validator as v;
use \App\Auth\Auth;
use \App\Entity\User;
/**
* 
*/
class PasswordController extends Controller
{
	public function getChangePassword($request, $response)
	{
		$this->renderer->render($response, 'changepassword.twig');
	}

	public function postChangePassword($request, $response)
	{
		$validator = $this->validation->validate($request, array(
			'old_password' => v::noWhitespace()->notEmpty()->MatchesUserPassword($request->getParam('old_password')),
			'password' => v::noWhitespace()->notEmpty()->SamePasswordCheck($request->getParam('old_password')),
		));

		if ($validator->failed()) {
			return $response->withRedirect($this->router->pathFor('changepassword'));
		}

		$auth = new Auth();
		$user = $this->db->find(User::class, $auth->userObj()->getId());
		$user->setPassword((password_hash($request->getParam('password'), PASSWORD_DEFAULT, ['cost' => 12])));
		$this->db->persist($user);
		$this->db->flush();

		$this->flash->addMessage('info', 'You successfuly change your password!');
		return $response->withRedirect($this->router->pathFor('home'));
	}
}