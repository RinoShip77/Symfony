<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

header('Access-Control-Allow-Origin: *');

class FavoriteController extends AbstractController
{
    //--------------------------------
    // Route to get all the favorites
    //--------------------------------
    #[Route('/favorites')]
    public function getAll(Connection $connexion): JsonResponse
    {
        $favorites = $connexion->fetchAllAssociative("SELECT * FROM favorites");
        return $this->json($favorites);
    }
}
