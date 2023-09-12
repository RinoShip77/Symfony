<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

header('Access-Control-Allow-Origin: *');

class BookController extends AbstractController
{
    //--------------------------------
    // Route to get all the books
    //--------------------------------
    #[Route('/books')]
    public function getAll(Connection $connexion): JsonResponse
    {
        $books = $connexion->fetchAllAssociative("SELECT * FROM books");
        return $this->json($books);
    }
}
