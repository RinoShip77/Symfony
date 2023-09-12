<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

header('Access-Control-Allow-Origin: *');

class EvaluationController extends AbstractController
{
    //--------------------------------
    // Route to get all the evalutions
    //--------------------------------
    #[Route('/evalutions')]
    public function getAll(Connection $connexion): JsonResponse
    {
        $evalutions = $connexion->fetchAllAssociative("SELECT * FROM evalutions");
        return $this->json($evalutions);
    }
}
