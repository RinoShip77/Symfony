<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

header('Access-Control-Allow-Origin: *');

class GenreController extends AbstractController
{
    //--------------------------------
    // Route to get all the genres
    //--------------------------------
    #[Route('/genres')]
    public function getAll(Connection $connexion): JsonResponse
    {
        $genres = $connexion->fetchAllAssociative("SELECT * FROM genres");
        return $this->json($genres);
    }
}
