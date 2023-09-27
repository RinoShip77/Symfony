<?php

namespace App\Controller;

use App\Entity\Book;
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
}
