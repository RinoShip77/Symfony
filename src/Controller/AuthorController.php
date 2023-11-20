<?php

namespace App\Controller;

use App\Entity\Author;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

header('Access-Control-Allow-Origin: *');

class AuthorController extends AbstractController
{
    private $em = null;

    //--------------------------------
    // Route to get all the authors
    //--------------------------------
    #[Route('/authors')]
    public function getAll(Connection $connexion): JsonResponse
    {
        $authors = $connexion->fetchAllAssociative("SELECT * FROM authors");

        return $this->json($authors);
    }
    
    //--------------------------------
    // Route to get all the authors
    //--------------------------------
    #[Route('/author/{idAuthor}')]
    public function getOne($idAuthor, Connection $connexion): JsonResponse
    {
        $author = $connexion->fetchAssociative("SELECT * FROM authors WHERE idAuthor = $idAuthor");
        
        return $this->json($author);
    }

    //--------------------------------
    //
    //--------------------------------
    #[Route('/create-author')]
    public function createAuthor(Request $req, ManagerRegistry $doctrine): JsonResponse
    {
        
        if ($req->getMethod() == 'POST') {
            
            $this->em = $doctrine->getManager();
            $author = new Author();
            
            $author->setFirstName($req->request->get('firstName'));
            $author->setLastName($req->request->get('lastName'));

            $this->em->persist($author);
            $this->em->flush();

            return $this->json($author);
        }
    }

    //--------------------------------
    // Route to get the number of books of an author
    //--------------------------------
    #[Route('/author/books/{idAuthor}')]
    public function getNumberOfBooks($idAuthor, Connection $connexion): JsonResponse
    {
        $number = $connexion->fetchAssociative("SELECT COUNT(DISTINCT idBook) FROM books Where idAuthor = $idAuthor");
        return $this->json($number['COUNT(DISTINCT idBook)']);
    }
}
