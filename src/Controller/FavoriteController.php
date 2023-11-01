<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Favorite;
use App\Entity\User;
use App\Entity\Book;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

ini_set('date.timezone', 'America/New_York');
header('Access-Control-Allow-Origin: *');

class FavoriteController extends AbstractController
{

    private $em = null;
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

    #[route('/create-favorite')]
    public function createFavorite(Request $req,ManagerRegistry $doctrine){
        if($req->getMethod()=='POST'){
            $this->em= $doctrine->getManager();
            $user=$this->em->getRepository(User::class)->find($req->request->get('idUser'));
            $book=$this->em->getRepository(Book::class)->find($req->request->get('idBook'));
            $favorite = new Favorite();
            $favorite->setUser($user);
            $favorite->setBook($book);
            $favorite->setFavoriteDate(new \DateTime());
            $this->em->persist($favorite);
            $this->em->flush();
            return new JsonResponse(['message' => 'Favoris crée avec succes'], 201);
        }
        
    }
}
