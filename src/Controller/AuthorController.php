<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

header('Access-Control-Allow-Origin: *');

class AuthorController extends AbstractController
{
    //--------------------------------
    // Route to get all the authors
    //--------------------------------
    #[Route('/authors')]
    public function getAll(Connection $connexion): JsonResponse
    {
        $authors = $connexion->fetchAllAssociative("SELECT * FROM authors");
        return $this->json($authors);
    }
}
