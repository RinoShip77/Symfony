<?php

namespace App\Controller;

use App\Entity\Reservation;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

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
                "isBorrowed" => $row["isBorrowed"],
                "originalLanguage" => $row["originalLanguage"],
            ];

            $reservation["user"] = $user;
            $reservation["book"] = $book;
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

    //--------------------------------
    //
    //--------------------------------
    #[Route('/reservations-data')]
    public function getReservationsData(Connection $connection)
    {
        $query = "SELECT
        r.idReservation,
        r.idUser AS reservationIdUser,
        u1.memberNumber AS reservationMemberNumber,
        bo.idUser AS borrowIdUser,
        u2.memberNumber AS borrowMemberNumber,
        bo.dueDate,
        bo.idBorrow
    FROM
        reservations r
    JOIN
        users u1 ON r.idUser = u1.idUser
    LEFT JOIN
        borrows bo ON r.idBook = bo.idBook
    LEFT JOIN
        users u2 ON bo.idUser = u2.idUser
        WHERE bo.returnedDate IS NULL";

        $result = $connection->fetchAllAssociative($query);

        return new JsonResponse($result);
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
        $query = "SELECT *
            FROM reservations r 
            INNER JOIN users u ON r.idUser = u.idUser 
            INNER JOIN books b ON r.idBook = b.idBook
            INNER JOIN borrows bo on b.idBook = bo.idBook
            WHERE r.idUser = $idUser";

        $reservationsData = $connexion->fetchAllAssociative($query);

        $reservations = [];
        foreach ($reservationsData as $row) {
            $reservation = [
                "idReservation" => $row["idReservation"],
                "reservationDate" => $row["reservationDate"],
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
                "isBorrowed" => $row["isBorrowed"],
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
        $query = "SELECT *
            FROM reservations r 
            INNER JOIN users u ON r.idUser = u.idUser 
            INNER JOIN books b ON r.idBook = b.idBook
            INNER JOIN borrows bo on b.idBook = bo.idBook
            WHERE r.idUser = $idUser
            ORDER BY r.idReservation";

        $reservationsData = $connexion->fetchAllAssociative($query);

        $reservations = [];
        foreach ($reservationsData as $row) {
            $reservation = [
                "idReservation" => $row["idReservation"],
                "reservationDate" => $row["reservationDate"],
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
                "isBorrowed" => $row["isBorrowed"],
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

    #[Route('/reservations/cancel/{idReservation}/')]
    public function cancelReservation($idReservation, Connection $connexion): JsonResponse
    {
        $query = "UPDATE *
            FROM reservations
            WHERE idReservation = $idReservation";

        $reservation = $connexion->executeStatement($query);
        return $this->json($reservation);
    }
}
