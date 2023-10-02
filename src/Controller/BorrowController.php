<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

header('Access-Control-Allow-Origin: *');

class BorrowController extends AbstractController
{
    //--------------------------------
    // Route to get all the borrows
    //--------------------------------
    #[Route('/borrows')]
    public function getAllFromUser(Request $request, Connection $connexion): JsonResponse
    {
        $borrows = $connexion->fetchAllAssociative("SELECT * FROM borrows");
        return $this->json($borrows);
    }

    #[Route('/borrows/{idUser}')]
    public function getBorrowsFromUser($idUser, Request $request, Connection $connexion): JsonResponse
    {
        //$borrows = $connexion->fetcha("SELECT * FROM borrows WHERE idUser=$idUser");
        $borrowsData = $connexion->fetchAllAssociative("
        SELECT * FROM borrows b
        INNER JOIN books g ON b.idBook = g.idBook
        WHERE idUser = $idUser
        ");

        $borrows = [];
        foreach ($borrowsData as $row) {
            $borrow = [
                "idBorrow" => $row["idBorrow"],
                "idUser" => $row["idUser"],
                "borrowedDate" => $row["borrowedDate"],
                "dueDate" => $row["dueDate"],
                "returnedDate" => $row["returnedDate"],
            ];

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
            ];

            $borrow["book"] = $book;
            $borrows[] = $borrow;
        }

        return $this->json($borrows);
    }

    #[Route('/borrows/{idUser}/{order}')]
    public function getBorrowsOrderedBy($idUser, $order, Request $request, Connection $connexion): JsonResponse
    {
        //$borrows = $connexion->fetcha("SELECT * FROM borrows WHERE idUser=$idUser");
        $borrowsData = $connexion->fetchAllAssociative("
        SELECT * FROM borrows b
        INNER JOIN books g ON b.idBook = g.idBook
        WHERE idUser = $idUser
        ORDER BY b.$order
        ");

        $borrows = [];
        foreach ($borrowsData as $row) {
            $borrow = [
                "idBorrow" => $row["idBorrow"],
                "idUser" => $row["idUser"],
                "borrowedDate" => $row["borrowedDate"],
                "dueDate" => $row["dueDate"],
                "returnedDate" => $row["returnedDate"],
            ];

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
            ];

            $borrow["book"] = $book;
            $borrows[] = $borrow;
        }

        return $this->json($borrows);
    }

    
}
