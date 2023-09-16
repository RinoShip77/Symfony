<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

header('Access-Control-Allow-Origin: *');

class BookController extends AbstractController
{
    //--------------------------------
    // Route to get all the books
    //--------------------------------
    #[Route('/books')]
    public function getAll(Request $request, Connection $connexion): JsonResponse
    {
        $idGenre = $request->query->get('idGenre');
        //$search = $request->query->get('search');

        if ($idGenre) {
            $books = $connexion->fetchAllAssociative("SELECT * FROM books WHERE idGenre IN($idGenre)");
        } else {
            $books = $connexion->fetchAllAssociative("SELECT * FROM books");
        }

        // if($search) {
        //     $books = $connexion->fetchAllAssociative("SELECT * FROM books WHERE title LIKE '%$search%'");
        // }

        return $this->json($books);
    }
}
