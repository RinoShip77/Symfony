<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Borrow;
use App\Entity\Book;
use App\Entity\User;
use App\Entity\Status;
use Symfony\Component\HttpFoundation\Response;
use App\Tools;
use Doctrine\Persistence\ManagerRegistry;
use DateTimeImmutable;
use Error;

ini_set('date.timezone', 'America/New_York');
header('Access-Control-Allow-Origin: *');

class BorrowController extends AbstractController
{
    private $em = null;

    #[Route('/borrows/borrow/{idBorrow}')]
    public function getOne($idBorrow, Request $request, Connection $connexion)
    {
        $query = 
        "SELECT * FROM borrows b
        INNER JOIN books o ON b.idBook = o.idBook
        WHERE idBorrow = $idBorrow";

        $borrowData = $connexion->fetchAllAssociative($query)[0];

        $borrow = [
            "idBorrow" => $borrowData["idBorrow"],
            "borrowedDate" => $borrowData["borrowedDate"],
            "dueDate" => $borrowData["dueDate"],
            "returnedDate" => $borrowData["returnedDate"],
        ];

        $book = [
            "idBook" => $borrowData["idBook"],
            "idGenre" => $borrowData["idGenre"],
            "idAuthor" => $borrowData["idAuthor"],
            "title" => $borrowData["title"],
            "description" => $borrowData["description"],
            "isbn" => $borrowData["isbn"],
            "cover" => $borrowData["cover"],
            "publishedDate" => $borrowData["publishedDate"],
            "originalLanguage" => $borrowData["originalLanguage"],
        ];

        $borrow["book"] = $book;

        return $this->json($borrow);
    }

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

    //--------------------------------
    // Route to get all the borrows
    //--------------------------------
    #[Route('/active-borrows')]
    public function getActiveBorrows(Request $request, Connection $connection): JsonResponse
    {
        $query = "SELECT b.*, u.*, o.* 
            FROM borrows b 
            INNER JOIN users u ON b.idUser = u.idUser 
            INNER JOIN books o ON b.idBook = o.idBook
            WHERE returnedDate IS NULL";

        $borrowsData = $connection->fetchAllAssociative($query);

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
        $borrowsData = $connexion->fetchAllAssociative("
        SELECT * FROM borrows b
        INNER JOIN books g ON b.idBook = g.idBook
        WHERE idUser = $idUser 
        AND returnedDate IS NULL
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
                "cover" => $row["cover"],
                "publishedDate" => $row["publishedDate"],
                "originalLanguage" => $row["originalLanguage"],
            ];

            $borrow["book"] = $book;
            $borrows[] = $borrow;
        }

        return $this->json($borrows);
    }

    #[Route('/borrows/history/{idUser}')]
    public function getBorrowsHistoryFromUser($idUser, Request $request, Connection $connexion): JsonResponse
    {
        //$borrows = $connexion->fetcha("SELECT * FROM borrows WHERE idUser=$idUser");
        $borrowsData = $connexion->fetchAllAssociative("
        SELECT * FROM borrows b
        INNER JOIN books g ON b.idBook = g.idBook
        WHERE idUser = $idUser
        AND returnedDate IS NOT NULL
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
        AND returnedDate IS NULL
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
                "cover" => $row["cover"],
                "publishedDate" => $row["publishedDate"],
                "originalLanguage" => $row["originalLanguage"],
            ];

            $borrow["book"] = $book;
            $borrows[] = $borrow;
        }

        return $this->json($borrows);
    }

    #[Route('/borrows/history/{idUser}/{order}')]
    public function getBorrowsHistoryOrderedBy($idUser, $order, Request $request, Connection $connexion): JsonResponse
    {
        //$borrows = $connexion->fetcha("SELECT * FROM borrows WHERE idUser=$idUser");
        $borrowsData = $connexion->fetchAllAssociative("
        SELECT * FROM borrows b
        INNER JOIN books g ON b.idBook = g.idBook
        WHERE idUser = $idUser
        AND returnedDate IS NOT NULL
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
                "cover" => $row["cover"],
                "publishedDate" => $row["publishedDate"],
                "originalLanguage" => $row["originalLanguage"],
            ];

            $borrow["book"] = $book;
            $borrows[] = $borrow;
        }

        return $this->json($borrows);
    }

    #[Route('renew/{idBorrow}')]
    public function renouvellement($idBorrow, Request $request, Connection $connexion): JsonResponse
    {
        //$borrows = $connexion->fetcha("SELECT * FROM borrows WHERE idUser=$idUser");
        $borrow = $connexion->executeStatement("
        UPDATE borrows
        SET dueDate = DATE_ADD(dueDate, INTERVAL 1 MONTH)
        WHERE idBorrow = $idBorrow;
        ");
        

        return $this->json($borrow);
    }

    //--------------------------------
    //
    //--------------------------------
    //je vais repasser pour split la fonction en deux avec setStatusBorrowed
    #[Route('/create-borrow')]
    public function createBorrow(Request $req, ManagerRegistry $doctrine): JsonResponse
    {
        if ($req->getMethod() == 'POST') {

            $this->em = $doctrine->getManager();
            $borrow = $this->setBorrow($req);

            $book = $this->em->getRepository(Book::class)->find($req->request->get('idBook'));
            $statusEnable = $this->em->getRepository(Status::class)->find(1);
            $statusBorrowed = $this->em->getRepository(Status::class)->find(2);

            if ($book->getStatus() == $statusEnable) {
                $book->setStatus($statusBorrowed);
            
                $this->em->persist($borrow);
                $this->em->flush();
                $this->em->persist($book);
                $this->em->flush();
                $jsonBorrow['idBorrow']=$borrow->getIdBorrow();
                return new JsonResponse($jsonBorrow);
            }
            

            return new JsonResponse(['error' => 'cannot borrow'], 409);
        }
        return new JsonResponse(["final countDown"]);    
    }

    //--------------------------------
    //
    //--------------------------------
    function setBorrow($req)
    {
        $borrow = new Borrow();
        $book = $this->em->getRepository(Book::class)->find($req->request->get('idBook'));
        $user = $this->em->getRepository(User::class)->find($req->request->get('idUser'));

        $borrow->setUser($user);
        $borrow->setBook($book);

        $borrow->setBorrowedDate(new \DateTime());
        $borrow->setDueDate(new \DateTime('+1 month'));

        return $borrow;
    }

    //dans la requete jai le id du livre, donc jenvoie la requete pis je change le status du livre que son id est dans la requete
    // function setStatusBorrowed($req,ManagerRegistry $doctrine){
    ///     $this->em = $doctrine->getManager();
    ///     $book = $this->em->getRepository(Book::class)->find($req->request->get('idBook'));
    ///     $book->setStatus(2);
    ///     $this->$em->persist($book);
    ///     $this->$em->flush();
    //  }

    #[Route('/return-borrow/{idBorrow}')]
    public function returnBorrow($idBorrow, Request $req, ManagerRegistry $doctrine): JsonResponse
    {

        if ($req->getMethod() == 'POST') {
            $this->em = $doctrine->getManager();

            $borrow = $this->em->getRepository(Borrow::class)->find($idBorrow);

            if (!$borrow) {
                return new JsonResponse(['error' => 'Borrow not found'], 404);
            }

            $borrow->setReturnedDate(new \DateTime());

            $book = $this->em->getRepository(Book::class)->find($borrow->getBook()->getIdBook());
            $status = $this->em->getRepository(Status::class)->find(1);
            $book->setStatus($status);
            $this->em->persist($book);

            $this->em->persist($borrow);
            $this->em->flush();

            return new JsonResponse(['message' => 'Borrow returned successfully']);
        }
    }

    //--------------------------------
    //
    //--------------------------------
    #[Route('/borrow/{idUser}/{idBook}')]
    public function getOneBorrowFromUser($idUser, $idBook, Connection $connexion): JsonResponse
    {
        $query = "SELECT idBorrow
            FROM borrows bo 
            INNER JOIN users u ON bo.idUser = u.idUser 
            INNER JOIN books b ON bo.idBook = b.idBook
            WHERE bo.idUser = $idUser
            AND bo.idBook = $idBook
            AND bo.returnedDate IS NULL";

        $borrowsData = $connexion->fetchAllAssociative($query);

        if (count($borrowsData) > 0) {
            return $this->json(true);
        }

        return $this->json(false);
    }

    #[Route('/return-late-borrow')]
    public function returnLateBorrow(Request $req, ManagerRegistry $doctrine): JsonResponse
    {


        if ($req->getMethod() == 'POST') {
            $this->em = $doctrine->getManager();

            $idBorrow = $req->request->get('idBorrow');
            $borrow = $this->em->getRepository(Borrow::class)->find($idBorrow);

            if (!$borrow) {
                return new JsonResponse(['error' => 'Borrow not found'], 404);
            }

            $fees = $req->request->get('fees');

            $borrow->setReturnedDate(new \DateTime());
            $book = $this->em->getRepository(Book::class)->find($borrow->getBook()->getIdBook());
            $user = $this->em->getRepository(User::class)->find($borrow->getUser()->getIdUser());
            $status = $this->em->getRepository(Status::class)->find(1);

            $book->setStatus($status);
            $userFees = $user->getFees() + $fees;
            $user->setFees($userFees);

            $this->em->persist($book);

            $this->em->persist($borrow);
            $this->em->flush();

            return new JsonResponse(['message' => 'Borrow returned successfully']);
        }
    }
}
