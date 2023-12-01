<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Genre;
use App\Entity\Author;
use App\Entity\Status;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Doctrine\Persistence\ManagerRegistry;
use App\Tools;


ini_set('date.timezone', 'America/New_York');
header('Access-Control-Allow-Origin: *');

class BookController extends AbstractController
{

    private $em = null;
    private $imagesDirectory = "./images/books/";

    //--------------------------------
    // Route to get all the books
    //--------------------------------
    #[Route('/books')]
    public function getBooks(Request $request, Connection $connexion): JsonResponse
    {
        $query = "SELECT b.*, a.*, g.*, s.* 
            FROM books b 
            INNER JOIN authors a ON b.idAuthor = a.idAuthor 
            INNER JOIN genres g ON b.idGenre = g.idGenre
            INNER JOIN status s ON b.idStatus = s.idStatus";
        
        $booksData = $connexion->fetchAllAssociative($query);

        return $this->json($this->setBooks($booksData));
    }

    //--------------------------------
    //
    //--------------------------------
    #[Route('/available-books')]
    public function getAvailableBooks(Request $request, Connection $connexion): JsonResponse
    {
        $query = "SELECT b.*, a.*, g.*, s.* 
            FROM books b 
            INNER JOIN authors a ON b.idAuthor = a.idAuthor 
            INNER JOIN genres g ON b.idGenre = g.idGenre
            INNER JOIN status s ON b.idStatus = s.idStatus
            WHERE s.status = 'Disponible'";
        
        $booksData = $connexion->fetchAllAssociative($query);

        return $this->json($this->setBooks($booksData));
    }

    //--------------------------------
    //
    //--------------------------------
    public function setBooks($booksData) {
        $books = [];
        foreach ($booksData as $row) {
            $book = [
                "idBook" => $row["idBook"],
                "title" => $row["title"],
                "description" => $row["description"],
                "isbn" => $row["isbn"],
                "cover" => $row["cover"],
                "publishedDate" => $row["publishedDate"],
                "originalLanguage" => $row["originalLanguage"],
                "isRecommended" => $row["isRecommended"],
                "addedDate" => $row["addedDate"],
            ];

            $author = [
                "idAuthor" => $row["idAuthor"],
                "firstName" => $row["firstName"],
                "lastName" => $row["lastName"],
            ];

            $genre = [
                "idGenre" => $row["idGenre"],
                "name" => $row["name"],
            ];

            $status = [
                "idStatus" => $row["idStatus"],
                "status" => $row["status"],
            ];

            $book["author"] = $author;
            $book["genre"] = $genre;
            $book["status"] = $status;
            $books[] = $book;
        }

        return $books;
    }

    #[Route('/get-book/{idBook}')]
    public function getOne($idBook, Request $request, Connection $connexion): JsonResponse
    {

        $query = "SELECT * from books WHERE idBook=$idBook";

        $book = $connexion->fetchAssociative($query);
        return $this->json($book);
    }

    #[Route('/getBookBorrowed/{idBook}')]
    public function getBookBorrowed($idBook, Request $request, Connection $connexion): JsonResponse
    {

        //$query = "SELECT * from books WHERE idBook=$idBook";

        $query = "SELECT b.*, a.*, g.* 
            FROM books b 
            INNER JOIN authors a ON b.idAuthor = a.idAuthor 
            INNER JOIN genres g ON b.idGenre = g.idGenre";

        $bookData = $connexion->fetchAssociative($query);

        $book = [
            "idBook" => $bookData["idBook"],
            "title" => $bookData["title"],
            "description" => $bookData["description"],
            "isbn" => $bookData["isbn"],
            "cover" => $bookData["cover"],
            "publishedDate" => $bookData["publishedDate"],
            "originalLanguage" => $bookData["originalLanguage"],
            "isRecommended" => $bookData["isRecommended"],
        ];

        $author = [
            "idAuthor" => $bookData["idAuthor"],
            "firstName" => $bookData["firstName"],
            "lastName" => $bookData["lastName"],
        ];

        $genre = [
            "idGenre" => $bookData["idGenre"],
            "name" => $bookData["name"],
        ];
        
        $book["author"] = $author;
        $book["genre"] = $genre;
        
        return $this->json($book);
    }

    //--------------------------------
    // Créer un livre en base de données
    //--------------------------------
    #[Route('/create-book')]
    public function createBook(Request $req, ManagerRegistry $doctrine): JsonResponse
    {
        
        if ($req->getMethod() == 'POST') {
            
            $this->em = $doctrine->getManager();
            $book = new Book();
            $this->setBook($req, $book);
            $book->setAddedDate(new \DateTime());

            $this->em->persist($book);
            $this->em->flush();

            // Gestion de l'image téléversée
            $uploadedFile = $req->files->get('cover');
            $newFilename = $book->getIdBook() . ".png";

            try {
                $uploadedFile->move($this->imagesDirectory, $newFilename);
            } catch (FileException $e) {
                return new Response('File upload failed: ' . $e->getMessage(), 500);
            }

            return new JsonResponse(['message' => 'Book created successfully']);
        }
    }

    //--------------------------------
    // Modifie les informations d'un livre en base de données
    //--------------------------------
    #[Route('/update-book/{idBook}')]
    public function updateBook($idBook, Request $req, ManagerRegistry $doctrine): JsonResponse
    {
        
        if ($req->getMethod() == 'POST') {
            
            $this->em = $doctrine->getManager();
            $book = $this->em->getRepository(Book::class)->find($idBook);

            if (!$book) {
                return new JsonResponse(['error' => 'Book not found'], 404);
            }

            $this->setBook($req, $book);

            $this->em->persist($book);
            $this->em->flush();

            
            // Gestion de l'image téléversée
            $uploadedFile = $req->files->get('cover');
            
            // Si une image a été transmise
            if (strlen($uploadedFile) > 0) {
                $newFilename = $book->getIdBook() . ".png";
                
                //Supprime l'image déjà existante avant d'en créer une nouvelle
                if ($this->deleteImage($newFilename)) {
                    try {
                        $uploadedFile->move($this->imagesDirectory, $newFilename);
                    } catch (FileException $e) {
                        return new Response('File upload failed: ' . $e->getMessage(), 500);
                    }
                }
                else {
                    try {
                        $uploadedFile->move($this->imagesDirectory, $newFilename);
                    } catch (FileException $e) {
                        return new Response('File upload failed: ' . $e->getMessage(), 500);
                    }
                }
            }
            
            return new JsonResponse(['message' => 'Book updated successfully']);
        }
    }

    //--------------------------------
    // Applique les informations transmises à un livre
    //--------------------------------
    function setBook($req, $book) {
        $book->setTitle($req->request->get('title'));
        $book->setDescription($req->request->get('description'));
        $book->setIsbn($req->request->get('isbn'));
        
        $book->setPublishedDate(new \DateTime($req->request->get('publishedDate')));
        $book->setOriginalLanguage($req->request->get('originalLanguage'));
        $book->setIsRecommended($req->request->get('isRecommended'));
        
        // Attribut inutile?
        //$book->setCover($req->request->get('cover'));
        $book->setCover("/");
        
        $idAuthor = $req->request->get('idAuthor');
        $author = $this->em->getRepository(Author::class)->find($idAuthor);
        $book->setAuthor($author);
        
        $idGenre = $req->request->get('idGenre');
        $genre = $this->em->getRepository(Genre::class)->find($idGenre);
        $book->setGenre($genre);

        $idStatus = $req->request->get('idStatus');
        $status = $this->em->getRepository(Status::class)->find($idStatus);
        $book->setStatus($status);
    }

    // À implémenter dans la vérification de l'image (plus-tard)
    function isPngExtension()
    {
        $name = $_FILES['file']['name'];
        $pattern = '/\.png$/i';
        
        if (preg_match($pattern, $name))
            return true;
        return false;
    }

    function deleteImage($filename)
    {
        $imagePath = $this->imagesDirectory . $filename;
        
        if (file_exists($imagePath)) {
            // Supprime l'image
            unlink($imagePath);

            return true;
        }
        return false;
    }
}
