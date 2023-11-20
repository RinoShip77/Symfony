<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Tools;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

header('Access-Control-Allow-Origin: *');

class GenreController extends AbstractController
{
    private $em = null;

    //--------------------------------
    // Route to get all the genres
    //--------------------------------
    #[Route('/genres')]
    public function getAll(Connection $connexion): JsonResponse
    {
        $genres = $connexion->fetchAllAssociative("SELECT * FROM genres ORDER BY name ASC");

        return $this->json($genres);
    }

    //--------------------------------
    // Route to get one genre
    //--------------------------------
    #[Route('/genre/{idGenre}')]
    public function getOne($idGenre, Connection $connexion): JsonResponse
    {
        $genre = $connexion->fetchAssociative("SELECT * FROM genres WHERE idGenre = $idGenre");

        return $this->json($genre);
    }

    //--------------------------------
    //
    //--------------------------------
    #[Route('/create-genre')]
    public function createGenre(Request $req, ManagerRegistry $doctrine): JsonResponse
    {

        if ($req->getMethod() == 'POST') {

            $this->em = $doctrine->getManager();
            $genre = new Genre();



            $genre->setName($req->request->get('name'));

            try {
                $this->em->persist($genre);
                $this->em->flush();
            } catch (\Throwable $th) {
                Tools::logmsg($th);
            }


            return $this->json($genre);
        }
    }

    //--------------------------------
    // Route to get the number of books in one genre
    //--------------------------------
    #[Route('/genre/books/{idGenre}')]
    public function getNumberOfBooks($idGenre, Connection $connexion): JsonResponse
    {
        $number = $connexion->fetchAssociative("SELECT COUNT(DISTINCT idBook) FROM books Where idGenre = $idGenre");
        return $this->json($number['COUNT(DISTINCT idBook)']);
    }
}
