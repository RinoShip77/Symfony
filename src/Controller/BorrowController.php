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
    public function getAllBorrows(Request $request, Connection $connexion): JsonResponse
    {
        $query = "SELECT b.*, u.*, o.* 
            FROM borrows b 
            INNER JOIN users u ON b.idUser = u.idUser 
            INNER JOIN books o ON b.idBook = o.idBook";

        $borrowsData = $connexion->fetchAllAssociative($query);
        
        $borrows = [];
        foreach ($borrowsData as $row) {
            $borrow = [
                "idBorrow" => $row["idBorrow"],
                "borrowedDate" => $row["borrowedDate"],
                "dueDate" => $row["dueDate"],
                "returnedDate" => $row["returnedDate"],
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

            $borrow["user"] = $user;
            $borrow["book"] = $book;
            $borrows[] = $borrow;
        }
        return $this->json($borrows);
    }

    #[Route('/borrows/{idUser}')]
    public function getBorrowsFromUser($idUser, Request $request, Connection $connexion): JsonResponse
    {
        //$borrows = $connexion->fetcha("SELECT * FROM borrows WHERE idUser=$idUser");
        $borrows = $connexion->fetchAllAssociative("
        SELECT * FROM borrows b
        INNER JOIN books g ON b.idBook = g.idBook
        WHERE idUser = $idUser
        ");

        return $this->json($borrows);
    }

    #[Route('/borrows/{idUser}/{order}')]
    public function getBorrowsOrderedBy($idUser, $order, Request $request, Connection $connexion): JsonResponse
    {
        //$borrows = $connexion->fetcha("SELECT * FROM borrows WHERE idUser=$idUser");
        $borrows = $connexion->fetchAllAssociative("
        SELECT * FROM borrows b
        INNER JOIN books g ON b.idBook = g.idBook
        WHERE idUser = $idUser
        ORDER BY b.$order
        ");

        return $this->json($borrows);
    }

    
}
