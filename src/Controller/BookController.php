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
        $search = $request->query->get('search');
        $query = "SELECT * FROM books";

        if ($idGenre && $search) {
            $query .= " WHERE title LIKE '%$search%' AND idGenre IN($idGenre)";
        }

        if($idGenre && !$search) {
            $query .= " WHERE idGenre IN($idGenre)";
        }
        
        if(!$idGenre && $search) {
            $query .= " WHERE title LIKE '%$search%'";
        }

        $books = $connexion->fetchAllAssociative($query);

        return $this->json($books);
    }
}
