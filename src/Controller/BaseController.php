<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

header('Access-Control-Allow-Origin: *');

class BaseController extends AbstractController
{
    //-------------------------------------
    // Connect a user to the application
    //-------------------------------------
    #[Route('/connection')]
    public function connection(Request $request, Connection $connection): JsonResponse
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        $user = $connection->FetchAllAssociative("SELECT * FROM users WHERE email = '$email' AND password = '$password'");

        if (isset($user[0]))
		{
			if ($user[0]['password'] === $password)
			{
				$newUser['idUser'] = $user[0]['idUser'];
				$newUser['email'] = $user[0]['email'];
				$newUser['firstName'] = $user[0]['firstName'];
				$newUser['lastName'] = $user[0]['lastName'];
				$newUser['address'] = $user[0]['address'];
				$newUser['phoneNumber'] = $user[0]['phoneNumber'];
				$newUser['postalCode'] = $user[0]['postalCode'];
				$newUser['roles'] = $user[0]['roles'];
				$newUser['password'] = $user[0]['password'];
				return $this->json($newUser);
			}
			else{
				return $this->json("erreur 112");
			}
		}
		else
		{
			return $this->json("erreur 117");
		}
        return $this->json($user);
    }

    //-------------------------------------
    // Route to get all the books
    //-------------------------------------
    #[Route('/getBooks')]
    public function getBooks(Connection $connexion): JsonResponse
    {
        $books = $connexion->fetchAllAssociative("SELECT * FROM books");
        return $this->json($books);
    }
}
