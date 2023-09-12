<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

header('Access-Control-Allow-Origin: *');

class UserController extends AbstractController
{
    //--------------------------------
    // Route to get all the users
    //--------------------------------
    #[Route('/users')]
    public function getAll(Connection $connexion): JsonResponse
    {
        $users = $connexion->fetchAllAssociative("SELECT * FROM users");
        return $this->json($users);
    }

    //--------------------------------
	// Connect a user to the application
	//--------------------------------
	#[Route('/users/connection')]
	public function connection(Request $request, Connection $connection): JsonResponse
	{
		$email = $request->request->get('email');
		$password = $request->request->get('password');

		$user = $connection->FetchAllAssociative("SELECT * FROM users WHERE email = '$email' AND password = '$password'");

		if (isset($user[0])) {
			if ($user[0]['password'] === $password) {
				$newUser['idUser'] = $user[0]['idUser'];
				$newUser['email'] = $user[0]['email'];
				$newUser['registrationDate'] = $user[0]['registrationDate'];
				$newUser['firstName'] = $user[0]['firstName'];
				$newUser['lastName'] = $user[0]['lastName'];
				$newUser['address'] = $user[0]['address'];
				$newUser['profilePicture'] = $user[0]['profilePicture'];
				$newUser['phoneNumber'] = $user[0]['phoneNumber'];
				$newUser['postalCode'] = $user[0]['postalCode'];
				$newUser['roles'] = $user[0]['roles'];
				$newUser['password'] = $user[0]['password'];
				return $this->json($newUser);
			} else {
				return $this->json("erreur 112");
			}
		} else {
			return $this->json("erreur 117");
		}
		return $this->json($user);
	}
}
