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

    //--------------------------------
    // Route to get the number of books of a status
    //--------------------------------
    #[Route('/status/books/{idStatus}')]
    public function getNumberOfBooks($idStatus, Connection $connexion): JsonResponse
    {
        $number = $connexion->fetchAssociative("SELECT COUNT(DISTINCT idBook) FROM books Where idStatus = $idStatus");
        return $this->json($number['COUNT(DISTINCT idBook)']);
    }
}
