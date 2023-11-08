<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Tools;


use Stripe;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

ini_set('date.timezone', 'America/New_York');
header('Access-Control-Allow-Origin: *');

class UserController extends AbstractController
{
	private $em = null;
	private $imagesDirectory = "images/users/templates/Picture";
	private $imagesDestinationDirectory = "images/users/";
	private $imagesExtension = ".png";

	//--------------------------------
	// Function to initialize the controller
	//--------------------------------
	public function __construct(ManagerRegistry $doctrine)
	{
		$this->em = $doctrine->getManager();
	}

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
		$memberNumber = $request->request->get('memberNumber');
		$password = $request->request->get('password');

		$user = $connection->FetchAllAssociative("SELECT * FROM users WHERE memberNumber = '$memberNumber' AND password = '$password'");

		if (isset($user[0])) {
			if ($user[0]['password'] === $password) {
				$newUser['idUser'] = $user[0]['idUser'];
				$newUser['memberNumber'] = $user[0]['memberNumber'];
				$newUser['password'] = $user[0]['password'];
				$newUser['registrationDate'] = $user[0]['registrationDate'];
				$newUser['email'] = $user[0]['email'];
				$newUser['firstName'] = $user[0]['firstName'];
				$newUser['lastName'] = $user[0]['lastName'];
				$newUser['profilePicture'] = $user[0]['profilePicture'];
				$newUser['address'] = $user[0]['address'];
				$newUser['phoneNumber'] = $user[0]['phoneNumber'];
				$newUser['postalCode'] = $user[0]['postalCode'];
				$newUser['roles'] = $user[0]['roles'];
				$newUser['fees'] = $user[0]['fees'];

				return $this->json($newUser);
			} else {
				return $this->json("erreur 112");
			}
		} else {
			return $this->json("erreur 117");
		}
		return $this->json($user);
	}

	//--------------------------------
	// Connect a user to the application
	//--------------------------------
	#[Route('/users/{idUser}')]
	public function updateProfile($idUser, Request $request): JsonResponse
	{
		$user = $this->em->getRepository(User::class)->find($idUser);
		$action = $request->request->get('action');


		switch ($action) {
			case 'updatePicture':
				copy($this->imagesDirectory . $request->request->get('pictureNumber') . $this->imagesExtension, $this->imagesDestinationDirectory . $user->getIdUser() . $this->imagesExtension);
				break;

			case 'updatePassword':
				$this->em->getRepository(User::class)->upgradePassword($user, $request->request->get('newPassword'));
				break;

			case 'activateAccount':
				$user->setRoles(['ROLE_USER']);
				break;

			case 'deactivateAccount':
				$user->setRoles(['ROLE_DEACTIVATE']);
				break;

			case 'updateInformations':
				$user->setEmail($request->request->get('email'));
				$user->setFirstName($request->request->get('firstName'));
				$user->setLastName($request->request->get('lastName'));
				$user->setAddress($request->request->get('address'));
				$user->setPostalCode($request->request->get('postalCode'));
				$user->setPhoneNumber($request->request->get('phoneNumber'));
				break;
		}

		if (!$action) {
			return $this->json($user);
		} else {
			$this->em->getRepository(User::class)->save($user, true);
		}


		return $this->json($user);
	}

	//--------------------------------
	//
	//--------------------------------
	#[Route('/create-user')]
	public function createBook(Request $req, ManagerRegistry $doctrine): JsonResponse
	{
		if ($req->getMethod() == 'POST') {

			$this->em = $doctrine->getManager();
			$user = new User();

			$user->setMemberNumber($this->generateUniqueMemberNumber());
			$user->setRegistrationDate(new \DateTime());
			$user->setFirstName($req->request->get('firstName'));
			$user->setLastName($req->request->get('lastName'));
			$user->setEmail($req->request->get('email'));
			$user->setAddress($req->request->get('address'));
			$user->setPostalCode(strtoupper($req->request->get('postalCode')));
			$user->setPhoneNumber(str_replace(['-', ' '], '', $req->request->get('phoneNumber')));
			$user->setRoles(json_decode($req->request->get('roles')));
			$user->setPassword($req->request->get('password'));
			$user->setFees(0);

			$this->em->persist($user);
			$this->em->flush();



			$userData = [
				'idUser' => $user->getIdUser(),
				'memberNumber' => $user->getMemberNumber(),
				'registrationDate' => $user->getRegistrationDate(),
				'firstName' => $user->getFirstName(),
				'lastName' => $user->getLastName(),
				'email' => $user->getEmail(),
				'address' => $user->getAddress(),
				'postalCode' => $user->getPostalCode(),
				'phoneNumber' => $user->getPhoneNumber(),
				'roles' => $user->getRoles(),
			];

			return new JsonResponse($userData);
		}
	}

	public function generateUniqueMemberNumber()
	{
		$unique = false;

		while (!$unique) {
			$memberNumber = mt_rand(10000000, 99999999);

			$existingUser =  $this->em->getRepository(User::class)->findOneBy(['memberNumber' => $memberNumber]);

			if (!$existingUser) {
				$unique = true;
			}
		}

		return $memberNumber;
	}

	//--------------------------------
	// Route to get all the users
	//--------------------------------
	#[Route('/payFees/{idUser}')]
	public function payFees($idUser, Request $request, Connection $connection)
	{
	
		/*
        //https:monDomaine.test/stripe-success?session_id={CHECKOUT_SESSION_ID}
        $successURL = $this->generateUrl('stripe_success', [], UrlGeneratorInterface::ABSOLUTE_URL) . "?stripe_id={CHECKOUT_SESSION_ID}";

        $sessionData = [
            'line_items' => [[
                'quantity' => 1,
                'price_data' => ['unit_amount' => $this->panier->getTotal() * 100, 'currency' => 'CAD', 'product_data' => ['name' => 'Osmose Parfums' ]]
            ]],
            'customer_email' => $user->getEmail(),
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'success_url' => $successURL,
            'cancel_url' => $this->generateUrl('stripe_cancel', [], UrlGeneratorInterface::ABSOLUTE_URL)
        ];

        //Extension curl nécessaire 
        $checkoutSession = \Stripe\Checkout\Session::create($sessionData);
        return $this->redirect($checkoutSession->url, 303);
		*/

		$reservation = $connection->executeStatement("UPDATE users SET fees = 0 WHERE idUser = $idUser");

        return $this->json($reservation);
	}
}
