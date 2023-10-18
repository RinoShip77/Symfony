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

ini_set('date.timezone', 'America/New_York');
header('Access-Control-Allow-Origin: *');

class UserController extends AbstractController
{
	private $em = null;
	private $imagesDirectory = "./images/users/";

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
	#[Route('/user/{idUser}')]
	public function updateProfile($idUser, Request $request): JsonResponse
	{
		$user = $this->em->getRepository(User::class)->find($idUser);
		$action = $request->request->get('action');

		switch ($action) {
			case 'updateProfilePicture':
				$uploadedFile = $request->files->get('profilePicture');

				if (strlen($uploadedFile) > 0) {
					$newFilename = $user->getIdUser() . ".png";

					if (Tools::deleteImage($this->imagesDirectory,  $newFilename)) {
						try {
							$uploadedFile->move($this->imagesDirectory, $newFilename);
						} catch (FileException $e) {
							return $this->json('File upload failed: ' . $e->getMessage(), 500);
						}
					}
				}
				break;

			case 'updatePassword':
				$this->em->getRepository(User::class)->upgradePassword($user, $request->request->get('newPassword'));
				break;

			case 'desactivate':
				$user->setRoles(['ROLE_DEACTIVATE']);
				break;

			case 'delete':
				$this->em->getRepository(User::class)->remove($user, true);
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
		$this->em->getRepository(User::class)->save($user, true);

		return $this->json($user);
	}
}
