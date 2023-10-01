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
        $query = "SELECT f.*, u.*, b.* 
            FROM favorites f 
            INNER JOIN users u ON f.idUser = u.idUser 
            INNER JOIN books b ON f.idBook = b.idBook";

        $favoritesData = $connexion->fetchAllAssociative($query);
        
        $favorites = [];
        foreach ($favoritesData as $row) {
            $favorite = [
                "idFavorite" => $row["idFavorite"],
                "favoriteDate" => $row["favoriteDate"],
            ];
            
            $user = [
                "idUser" => $row["idUser"],
                "memberNumber" => $row["memberNumber"],
                "firstName" => $row["firstName"],
                "lastName" => $row["lastName"],
                "roles" => $row["roles"],
            ];

            $book = [
                "idBook" => $row["idBook"],
                "title" => $row["title"],
            ];

            $favorite["user"] = $user;
            $favorite["book"] = $book;
            $favorites[] = $favorite;
        }
        return $this->json($favorites);
    }
}
