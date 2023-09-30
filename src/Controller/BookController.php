<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Genre;
use App\Entity\Author;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Doctrine\Persistence\ManagerRegistry;
use App\Util;

header('Access-Control-Allow-Origin: *');

class BookController extends AbstractController
{

    private $em = null;

    //--------------------------------
    // Route to get all the books
    //--------------------------------
    #[Route('/books')]
    public function getAll(Request $request, Connection $connexion): JsonResponse
    {
        $idGenre = $request->request->get('idGenre');
        $search = $request->request->get('search');
        $query = "SELECT b.*, a.*, g.* FROM books b INNER JOIN genres g ON b.idGenre = g.idGenre INNER JOIN authors a ON b.idAuthor = a.idAuthor";

        $booksData = $connexion->fetchAllAssociative($query);

        $books = [];
        foreach ($booksData as $row) {
            $book = [
                "idBook" => $row["idBook"],
                "idGenre" => $row["idGenre"],
                "idAuthor" => $row["idAuthor"],
                "title" => $row["title"],
                "description" => $row["description"],
                "isbn" => $row["isbn"],
                "isBorrowed" => $row["isBorrowed"],
                "cover" => $row["cover"],
                "publishedDate" => $row["publishedDate"],
                "originalLanguage" => $row["originalLanguage"],
                "isFavorite" => $row["isFavorite"],
            ];

            $genre = [
                "idGenre" => $row["idGenre"],
                "name" => $row["name"],
                "icon" => $row["icon"]
            ];

            $author = [
                "idAuthor" => $row["idAuthor"],
                "firstName" => $row["firstName"],
                "lastName" => $row["lastName"],
            ];

            $borrow = [
                "idBorrow" => $row["idBorrow"]
            ];

            $book["genre"] = $genre;
            $book["author"] = $author;
            $book["borrow"] = $borrow;
            $books[] = $book;
        }

        return $this->json($books);
    }

    #[Route('/getBook/{idBook}')]
    public function getOne($idBook, Connection $connexion): JsonResponse
    {
        $query = "SELECT * from books WHERE idBook=$idBook";

        $book = $connexion->fetchAssociative($query);
        return $this->json($book);
    }

    //--------------------------------
    // Créer un livre en base de données
    //--------------------------------
    #[Route('/createBook')]
    public function createBook(Request $req, ManagerRegistry $doctrine): JsonResponse
    {

        if ($req->getMethod() == 'POST') {

            $this->em = $doctrine->getManager();

            $book = new Book();
            $book->setTitle($req->request->get('title'));
            $book->setDescription($req->request->get('description'));
            $book->setIsbn($req->request->get('isbn'));

            $book->setPublishedDate(new \DateTime($req->request->get('publishedDate')));
            $book->setOriginalLanguage($req->request->get('originalLanguage'));
            $book->setIsBorrowed($req->request->get('isBorrowed'));

            // Attribut inutile?
            //$book->setCover($req->request->get('cover'));
            $book->setCover("/");

            $idAuthor = $req->request->get('idAuthor');
            $author = $this->em->getRepository(Author::class)->find($idAuthor);
            $book->setAuthor($author);

            $idGenre = $req->request->get('idGenre');
            $genre = $this->em->getRepository(Genre::class)->find($idGenre);
            $book->setGenre($genre);

            $this->em->persist($book);
            $this->em->flush();

            $retBook['idBook'] = $book->getIdBook();
            $retBook['title'] = $book->getTitle();
            $retBook['description'] = $book->getDescription();
            $retBook['isbn'] = $book->getIsbn();
            $retBook['publishedDate'] = $book->getPublishedDate();
            $retBook['originalLanguage'] = $book->getOriginalLanguage();

            // Gestion de l'image téléversée
            $uploadedFile = $req->files->get('cover');
            $destinationDirectory = './images/books/';
            $newFilename = $book->getIdBook() . ".png";

            try {
                $uploadedFile->move($destinationDirectory, $newFilename);
            } catch (FileException $e) {
                return new Response('File upload failed: ' . $e->getMessage(), 500);
            }

            return $this->json($retBook);
        }
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
}
