<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

header('Access-Control-Allow-Origin: *');

class BaseController extends AbstractController
{
	//--------------------------------
	// Base for for the application
	//--------------------------------
	#[Route('/base')]
	public function base(): JsonResponse
	{
		return $this->json([
			'message' => 'Welcome to your base controller!',
			'path' => 'src/Controller/BaseController.php',
		]);
	}
}
