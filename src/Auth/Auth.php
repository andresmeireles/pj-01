<?php 
namespace App\Auth;

use App\Entity\User;
/**
* 
*/
class Auth
{
	private $em;

	function __construct()
	{
		require __DIR__.'/../../config/bootstrap.php';
		$this->em = $entityManager;
	}

	public function user()
	{
		if (isset($_SESSION['user'])) {
			return $this->em->getRepository(User::class)->find($_SESSION['user'])->toArray();			
		}
	}

	public function userObj()
	{
		if (isset($_SESSION['user'])) {
			return $this->em->getRepository(User::class)->find($_SESSION['user']);			
		}
	}

	public function check()
	{
		return $_SESSION['user'];
	}


	public function attempt($email, $password)
	{
		// retrive user by email
		$user = $this->em->getRepository(User::class)->findBy(['userEmail' => $email]);
		$user = reset($user);

		// if not exist return false
		if (!$user) {
			return false;
		}

		//if exist compare password and save id in session
		if (password_verify($password, $user->getPassword())) {
			$_SESSION['user'] = $user->getId();
			return true;
		}

		return false;
	}

	public function logout()
	{
		unset($_SESSION['user']);
	}
}