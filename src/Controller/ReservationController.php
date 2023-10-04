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
}
