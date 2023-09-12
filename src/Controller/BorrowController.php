<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

header('Access-Control-Allow-Origin: *');

class BorrowController extends AbstractController
{
    //--------------------------------
    // Route to get all the borrows
    //--------------------------------
    #[Route('/borrows')]
    public function getAll(Connection $connexion): JsonResponse
    {
        $borrows = $connexion->fetchAllAssociative("SELECT * FROM borrows");
        return $this->json($borrows);
    }
}
