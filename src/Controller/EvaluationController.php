<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

ini_set('date.timezone', 'America/New_York');
header('Access-Control-Allow-Origin: *');

class EvaluationController extends AbstractController
{
    //--------------------------------
    // Route to get all the evalutions
    //--------------------------------
    #[Route('/evaluations')]
    public function getAll(Connection $connexion): JsonResponse
    {
        $query = "SELECT e.*, u.*, b.* 
            FROM evaluations e 
            INNER JOIN users u ON e.idUser = u.idUser 
            INNER JOIN books b ON e.idBook = b.idBook";

        $evaluationsData = $connexion->fetchAllAssociative($query);
        
        $evaluations = [];
        foreach ($evaluationsData as $row) {
            $evaluation = [
                "idEvaluation" => $row["idEvaluation"],
                "score" => $row["score"],
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

            $evaluation["user"] = $user;
            $evaluation["book"] = $book;
            $evaluations[] = $evaluation;
        }
        return $this->json($evaluations);
    }
}
