<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

header('Access-Control-Allow-Origin: *');

class StatusController extends AbstractController
{
    #[Route('/all-status')]
    public function getAll(Connection $connexion): JsonResponse
    {
        $status = $connexion->fetchAllAssociative("SELECT * FROM status");

        return $this->json($status);
    }
}
