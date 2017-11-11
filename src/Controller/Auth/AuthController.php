<?php
namespace App\Controller\Auth;

// Por estar um diretorio acima é necessaria a importação do arquivo controller
use App\Controller\Controller;
use Respect\Validation\Validator as v;
use App\Entity\User;
use App\Auth\Auth;
/**
*
*/
class AuthController extends Controller
{
	public function getSignOut($request, $response)
	{
		$this->auth->logout();

		return $response->withRedirect($this->router->pathFor('home'));
	}

	public function getSignup($request, $response)
	{
		if ($_SESSION['user']) {
			return $response->withRedirect($this->router->pathFor('home'));
		}
		$this->renderer->render($response, 'signup.twig');
	}

	public function postSignup($request, $response)
	{
		$validator = $this->validation->validate($request, [
			'name' => v::noWhitespace()->notEmpty()->alpha(),
			'lastname' => v::optional(v::alpha()),
			'email' => v::noWhitespace()->notEmpty()->email()->EmailAvailable(),
			'password' => v::noWhitespace()->notEmpty()->length(8),
		]);


		if ($validator->failed()) {
			return $response->withRedirect($this->router->pathFor('auth.signup'));
		}

		$addUser = new User;

		$addUser->setUserName($request->getParam('name'));
		$addUser->setUserLastName($request->getParam('lastname'));
		$addUser->setUserEmail($request->getParam('email'));
		$addUser->setPassword(password_hash($request->getParam('password'), PASSWORD_DEFAULT, ['cost' => 12]));

		$this->db->persist($addUser);
		$this->db->flush();

		// Automaticamente conectar usuario
		$this->auth->attempt($request->getParam('email'), $request->getParam('password'));

		$this->flash->addMessage('info', 'You successfuly sign up!');
		return $response->withRedirect($this->router->pathFor('home'));
	}

	public function getSignin($request, $response)
	{ 
		if ($_SESSION['user']) {
			return $response->withRedirect($this->router->pathFor('home'));
		}
		return $this->renderer->render($response, 'signin.twig');
	}

	/**
	* Check if user exist and redirect to relative page.
	* @param $request = instance of Psr\Http\Message\RequestInterface
	* @param $response = instance of Psr\Http\Message\ResponseInterface
	* 
	* Method recive his params and user App\Auth\Auth dependency to check if user is valid. 
	* If valid redirect to home
	* If not valid return to sign in page
	*/
	public function postSignin($request, $response)
	{
		// check if user exist and connect him
		$auth = $this->auth->attempt($request->getParam('email'), $request->getParam('password'));

		// if not exist return to sign page
		if (!$auth) {
			$this->flash->addMessage('error', 'email or password incorrect');
			return $response->withRedirect($this->router->pathFor('auth.signin'));
		}

		// if Ok return to home
		return $response->withRedirect($this->router->pathFor('home'));
	}
}
