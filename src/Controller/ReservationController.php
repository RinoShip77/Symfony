<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Tools;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Book;
use App\Entity\User;

ini_set('date.timezone', 'America/New_York');
header('Access-Control-Allow-Origin: *');

class ReservationController extends AbstractController
{
    private $em = null;

    //--------------------------------
    // Route to get all the reservations
    //--------------------------------
    #[Route('/reservations')]
    public function getAll(Connection $connexion): JsonResponse
    {
        $query = "SELECT r.*, u.*, b.* 
            FROM reservations r 
            INNER JOIN users u ON r.idUser = u.idUser 
            INNER JOIN books b ON r.idBook = b.idBook";

        $reservationsData = $connexion->fetchAllAssociative($query);

        $reservations = [];
        foreach ($reservationsData as $row) {
            $reservation = [
                "idReservation" => $row["idReservation"],
                "reservationDate" => $row["reservationDate"],
                "isActive" => $row["isActive"],
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
                "idGenre" => $row["idGenre"],
                "idAuthor" => $row["idAuthor"],
                "title" => $row["title"],
                "description" => $row["description"],
                "cover" => $row["cover"],
                "isbn" => $row["isbn"],
                "originalLanguage" => $row["originalLanguage"],
            ];

            $reservation["user"] = $user;
            $reservation["book"] = $book;
            $reservations[] = $reservation;
        }
        return $this->json($reservations);
    }

    //--------------------------------
    // Route to get all the reservations
    //--------------------------------
    #[Route('/admin-reservations')]
    public function getAllForAdmin(Connection $connexion): JsonResponse
    {
        $query = "SELECT
        r.*,
        u.idUser AS userId,
        u.memberNumber AS userMemberNumber,
        u.firstName, u.lastName, u.roles,
        b.idBook AS bookId,
        b.idGenre, b.idAuthor, b.title, b.description, b.cover, b.isbn, b.originalLanguage,   
        bo.*,
        bo.dueDate AS borrowDueDate,
        u2.memberNumber AS borrowMemberNumber
        FROM reservations r
        INNER JOIN users u ON r.idUser = u.idUser
        INNER JOIN books b ON r.idBook = b.idBook
        LEFT JOIN (
            SELECT idBook, MAX(idBorrow) AS maxBorrowID
            FROM borrows
            GROUP BY idBook
        ) maxBorrow ON r.idBook = maxBorrow.idBook
        LEFT JOIN borrows bo ON maxBorrow.maxBorrowID = bo.idBorrow
        LEFT JOIN users u2 ON bo.idUser = u2.idUser;";


        $reservationsData = $connexion->fetchAllAssociative($query);

        $reservations = [];
        foreach ($reservationsData as $row) {
            $reservation = [
                "idReservation" => $row["idReservation"],
                "reservationDate" => $row["reservationDate"],
                "isActive" => $row["isActive"],
                "borrowMemberNumber" => $row["borrowMemberNumber"],
                "borrowDueDate" => $row["borrowDueDate"],
            ];

            $user = [
                "idUser" => $row["userId"],
                "memberNumber" => $row["userMemberNumber"],
                "firstName" => $row["firstName"],
                "lastName" => $row["lastName"],
                "roles" => $row["roles"],
            ];
    
            $book = [
                "idBook" => $row["bookId"],
                "idGenre" => $row["idGenre"],
                "idAuthor" => $row["idAuthor"],
                "title" => $row["title"],
                "description" => $row["description"],
                "cover" => $row["cover"],
                "isbn" => $row["isbn"],
                "originalLanguage" => $row["originalLanguage"],
            ];
            $borrow = [
                "idBorrow" => $row["idBorrow"],
                "borrowedDate" => $row["borrowedDate"],
                "dueDate" => $row["dueDate"],
                "returnedDate" => $row["returnedDate"],
            ];

            $reservation["user"] = $user;
            $reservation["book"] = $book;
            $reservation["borrow"] = $borrow;
            $reservations[] = $reservation;
        }
        return $this->json($reservations);
    }

    //--------------------------------
    //
    //--------------------------------
    #[Route('/cancel-reservation/{idReservation}')]
    public function cancelReservation($idReservation, Request $req, ManagerRegistry $doctrine): JsonResponse
    {

        if ($req->getMethod() == 'POST') {
            $this->em = $doctrine->getManager();

            $reservation = $this->em->getRepository(Reservation::class)->find($idReservation);


            if (!$reservation) {
                return new JsonResponse(['error' => 'Reservation not found'], 404);
            }


            $reservation->setIsActive(false);

            $this->em->persist($reservation);
            $this->em->flush();

            return new JsonResponse(['message' => 'Reservation canceled successfully']);
        }
    }

    #[Route('/reservations/book/{idBook}')]
    public function getBorrowBook($idBook, Connection $connexion): JsonResponse
    {
        $borrow = $connexion->fetchAllAssociative(
            "SELECT * FROM borrows
            WHERE idBook = $idBook"
        );

        return $this->json($borrow);
    }

    //--------------------------------
    // Route to get all the reservations
    //--------------------------------
    #[Route('/reservations/{idUser}')]
    public function getAllFromUser($idUser, Connection $connexion): JsonResponse
    {
        $query = "SELECT r.*, u.*, b.*, bo.idBorrow, bo.borrowedDate, bo.dueDate, bo.returnedDate
            FROM reservations r 
            INNER JOIN users u ON r.idUser = u.idUser 
            INNER JOIN books b ON r.idBook = b.idBook
            LEFT JOIN borrows bo on b.idBook = bo.idBook
            WHERE r.idUser = $idUser";

        $reservationsData = $connexion->fetchAllAssociative($query);

        $reservations = [];
        foreach ($reservationsData as $row) {
            $reservation = [
                "idReservation" => $row["idReservation"],
                "reservationDate" => $row["reservationDate"],
                "isActive" => $row["isActive"]
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
                "idGenre" => $row["idGenre"],
                "idAuthor" => $row["idAuthor"],
                "description" => $row["description"],
                "title" => $row["title"],
                "isbn" => $row["isbn"],
                "cover" => $row["cover"],
                "originalLanguage" => $row["originalLanguage"],
            ];

            $borrow = [
                "idBorrow" => $row["idBorrow"],
                "borrowedDate" => $row["borrowedDate"],
                "dueDate" => $row["dueDate"],
                "returnedDate" => $row["returnedDate"]
            ];

            $reservation["user"] = $user;
            $reservation["book"] = $book;
            $reservation["borrow"] = $borrow;
            $reservations[] = $reservation;
        }
        return $this->json($reservations);
    }

    #[Route('/reservations/{idUser}/{order}')]
    public function getReservationsOrderedBy($idUser, $order, Connection $connexion): JsonResponse
    {
        $query = "SELECT r.*, u.*, b.*, bo.idBorrow, bo.borrowedDate, bo.dueDate, bo.returnedDate
            FROM reservations r 
            INNER JOIN users u ON r.idUser = u.idUser 
            INNER JOIN books b ON r.idBook = b.idBook
            LEFT JOIN borrows bo on b.idBook = bo.idBook
            WHERE r.idUser = $idUser
            ORDER BY $order";

        $reservationsData = $connexion->fetchAllAssociative($query);

        $reservations = [];
        foreach ($reservationsData as $row) {
            $reservation = [
                "idReservation" => $row["idReservation"],
                "reservationDate" => $row["reservationDate"],
                "isActive" => $row["isActive"]
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
                "idGenre" => $row["idGenre"],
                "idAuthor" => $row["idAuthor"],
                "isbn" => $row["isbn"],
                "title" => $row["title"],
                "description" => $row["description"],
                "cover" => $row["cover"],
                "originalLanguage" => $row["originalLanguage"],
            ];

            $borrow = [
                "idBorrow" => $row["idBorrow"],
                "borrowedDate" => $row["borrowedDate"],
                "dueDate" => $row["dueDate"],
                "returnedDate" => $row["returnedDate"]
            ];

            $reservation["user"] = $user;
            $reservation["book"] = $book;
            $reservation["borrow"] = $borrow;
            $reservations[] = $reservation;
        }
        return $this->json($reservations);
    }

    #[Route('/reservations-cancel/{idReservation}')]
    public function cancelReservationUser($idReservation, Request $request, Connection $connexion): JsonResponse
    {
        $reservation = $connexion->executeStatement("UPDATE reservations SET isActive = 0 WHERE idReservation = $idReservation");

        return $this->json($reservation);
    }

    #[Route('/reservations-reactivate/{idReservation}')]
    public function reactivateReservationUser($idReservation, Request $request, Connection $connexion): JsonResponse
    {
        $reservation = $connexion->executeStatement("UPDATE reservations SET isActive = 1 WHERE idReservation = $idReservation");

        $reservation = $connexion->executeStatement("
        UPDATE reservations
        SET reservationDate = NOW()
        WHERE idReservation = $idReservation;
        ");

        return $this->json($reservation);
    }

    //--------------------------------
    //
    //--------------------------------
    #[Route('/create-reservation')]
    public function createReservation(Request $req, ManagerRegistry $doctrine): JsonResponse
    {
        if ($req->getMethod() == 'POST') {

            $this->em = $doctrine->getManager();
            $reservation = new Reservation();
            $book = $this->em->getRepository(Book::class)->find($req->request->get('idBook'));
            $user = $this->em->getRepository(User::class)->find($req->request->get('idUser'));

            $reservation->setUser($user);
            $reservation->setBook($book);


            $reservation->setReservationDate(new \DateTime());
            $reservation->setIsActive(true);

            $this->em->persist($reservation);
            $this->em->flush();
            $this->em->persist($book);
            $this->em->flush();

            return new JsonResponse(["Reservation created successfully"]);
        }
        return new JsonResponse(['error' => 'cannot reserve'], 409);
    }

    //--------------------------------
    //
    //--------------------------------
    #[Route('/reservation/{idUser}/{idBook}')]
    public function getOneReservationFromUser($idUser, $idBook, Connection $connexion): JsonResponse
    {
        $query = "SELECT idReservation
            FROM reservations r 
            INNER JOIN users u ON r.idUser = u.idUser 
            INNER JOIN books b ON r.idBook = b.idBook
            WHERE r.idUser = $idUser
            AND r.idBook = $idBook
            AND r.isActive";

        $reservationsData = $connexion->fetchAllAssociative($query);

        if (count($reservationsData) > 0) {
            return $this->json(true);
        }

        return $this->json(false);
    }

    //--------------------------------
    //
    //--------------------------------
    #[Route('/book-reservations/{idBook}')]
    public function getBookReservations($idBook, Connection $connexion): JsonResponse
    {
        $query = "SELECT r.*, u.*, b.* 
            FROM reservations r 
            INNER JOIN users u ON r.idUser = u.idUser 
            INNER JOIN books b ON r.idBook = b.idBook
            WHERE r.idBook = $idBook
            AND r.isActive";

        $reservationsData = $connexion->fetchAllAssociative($query);

        $reservations = [];
        foreach ($reservationsData as $row) {
            $reservation = [
                "idReservation" => $row["idReservation"],
                "reservationDate" => $row["reservationDate"],
                "isActive" => $row["isActive"],
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
                "idGenre" => $row["idGenre"],
                "idAuthor" => $row["idAuthor"],
                "title" => $row["title"],
                "description" => $row["description"],
                "cover" => $row["cover"],
                "isbn" => $row["isbn"],
                "originalLanguage" => $row["originalLanguage"],
            ];

            $reservation["user"] = $user;
            $reservation["book"] = $book;
            $reservations[] = $reservation;
        }
        return $this->json($reservations);
    }
}
