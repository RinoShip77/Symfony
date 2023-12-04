<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Review;
use App\Entity\User;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

ini_set('date.timezone', 'America/New_York');
header('Access-Control-Allow-Origin: *');

class ReviewController extends AbstractController
{
    private $em = null;

    //--------------------------------
    // Route to get all the comments
    //--------------------------------
    #[Route('/reviews/{idBook}')]
    public function getAll($idBook, Connection $connexion): JsonResponse
    {
        $reviewsData = $connexion->fetchAllAssociative("
        SELECT * FROM reviews r
        INNER JOIN users u ON r.idUser = u.idUser
        WHERE idBook = $idBook
        ORDER BY reviewDate DESC
        ");

        $reviews = [];
        foreach ($reviewsData as $row) {
            $review = [
                "idReview" => $row["idReview"],
                "message" => $row["message"],
                "rating" => $row["rating"],
                "reviewDate" => $row["reviewDate"]
            ];

            $user = [
                "idUser" => $row["idUser"],
                "memberNumber" => $row["memberNumber"],
                "email" => $row["email"],
                "firstName" => $row["firstName"],
                "lastName" => $row["lastName"],
                "roles" => $row["roles"],
                "phoneNumber" => $row["phoneNumber"],
                "profilePicture" => $row["profilePicture"],
            ];

            $review["user"] = $user;
            $reviews[] = $review;
        }

        return $this->json($reviews);
    }

    //--------------------------------
    // Route to create a comment
    //--------------------------------
    #[Route('/create-review')]
    public function createReview(Request $req, Connection $connexion, ManagerRegistry $doctrine): JsonResponse
    {
        if ($req->getMethod() == 'POST') {
            
            $this->em = $doctrine->getManager();
            $review = new Review();

            $this->setReview($req, $review);

            $this->em->persist($review);
            $this->em->flush();


            return new JsonResponse(['message' => 'Évaluation créée avec succès']);
        }

        return new JsonResponse(['message' => 'Erreur dans création de lévaluation']);
    }

    function setReview($req, $review) {
        $review->setMessage($req->request->get('message'));
        $review->setRating($req->request->get('rating'));
        $review->setReviewDate(new \DateTime());
        
        $idUser = $req->request->get('idUser');
        $user = $this->em->getRepository(User::class)->find($idUser);
        $review->setUser($user);

        $idBook = $req->request->get('idBook');
        $book = $this->em->getRepository(Book::class)->find($idBook);
        $review->setBook($book);
        
    }
}
