<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

ini_set('date.timezone', 'America/New_York');
header('Access-Control-Allow-Origin: *');

class ReservationController extends AbstractController
{
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
                "title" => $row["title"],
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
}
