<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

header('Access-Control-Allow-Origin: *');

class ReservationController extends AbstractController
{
    //--------------------------------
    // Route to get all the reservations
    //--------------------------------
    #[Route('/reservations')]
    public function getAll(Connection $connexion): JsonResponse
    {
        $reservations = $connexion->fetchAllAssociative("SELECT * FROM reservations");
        return $this->json($reservations);
    }
}
