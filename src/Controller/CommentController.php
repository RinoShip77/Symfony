<?php

namespace App\Controller;

use App\Entity\Comment;
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

class CommentController extends AbstractController
{
    private $em = null;

    //--------------------------------
    // Route to get all the comments
    //--------------------------------
    #[Route('/comments/{order}')]
    public function getAll($order, Connection $connexion): JsonResponse
    {
        $commentsData = $connexion->fetchAllAssociative("
        SELECT * FROM comment c
        INNER JOIN users u ON c.idUser = u.idUser
        ORDER BY createdDate $order
        ");

        $comments = [];
        foreach ($commentsData as $row) {
            $comment = [
                "idComment" => $row["idComment"],
                "reason" => $row["reason"],
                "content" => $row["content"],
                "isFixed" => $row["isFixed"],
                "createdDate" => $row["createdDate"],
                "resolvedDate" => $row["resolvedDate"]
            ];

            $user = [
                "idUser" => $row["idUser"],
                "memberNumber" => $row["memberNumber"],
                "email" => $row["email"],
                "firstName" => $row["firstName"],
                "lastName" => $row["lastName"],
                "roles" => $row["roles"],
                "phoneNumber" => $row["phoneNumber"],
            ];

            $comment["user"] = $user;
            $comments[] = $comment;
        }

        return $this->json($comments);
    }

    //--------------------------------
    // Route to get all the resolved comments
    //--------------------------------
    #[Route('/comments-resolved/{order}')]
    public function getAllResolved($order, Connection $connexion): JsonResponse
    {
        $commentsData = $connexion->fetchAllAssociative("
        SELECT * FROM comment c
        INNER JOIN users u ON c.idUser = u.idUser
        WHERE isFixed = 1
        ORDER BY createdDate $order
        ");

        $comments = [];
        foreach ($commentsData as $row) {
            $comment = [
                "idComment" => $row["idComment"],
                "reason" => $row["reason"],
                "content" => $row["content"],
                "isFixed" => $row["isFixed"],
                "createdDate" => $row["createdDate"],
                "resolvedDate" => $row["resolvedDate"]
            ];

            $user = [
                "idUser" => $row["idUser"],
                "memberNumber" => $row["memberNumber"],
                "email" => $row["email"],
                "firstName" => $row["firstName"],
                "lastName" => $row["lastName"],
                "roles" => $row["roles"],
                "phoneNumber" => $row["phoneNumber"],
            ];

            $comment["user"] = $user;
            $comments[] = $comment;
        }

        return $this->json($comments);
    }

    //--------------------------------
    // Route to get all the resolved comments
    //--------------------------------
    #[Route('/comments-not-resolved/{order}')]
    public function getAllNotResolved($order, Connection $connexion): JsonResponse
    {
        $commentsData = $connexion->fetchAllAssociative("
        SELECT * FROM comment c
        INNER JOIN users u ON c.idUser = u.idUser
        WHERE isFixed = 0
        ORDER BY createdDate $order
        ");

        $comments = [];
        foreach ($commentsData as $row) {
            $comment = [
                "idComment" => $row["idComment"],
                "reason" => $row["reason"],
                "content" => $row["content"],
                "isFixed" => $row["isFixed"],
                "createdDate" => $row["createdDate"],
                "resolvedDate" => $row["resolvedDate"]
            ];

            $user = [
                "idUser" => $row["idUser"],
                "memberNumber" => $row["memberNumber"],
                "email" => $row["email"],
                "firstName" => $row["firstName"],
                "lastName" => $row["lastName"],
                "roles" => $row["roles"],
                "phoneNumber" => $row["phoneNumber"],
            ];

            $comment["user"] = $user;
            $comments[] = $comment;
        }

        return $this->json($comments);
    }

    //--------------------------------
    // Route to create a comment
    //--------------------------------
    #[Route('/create-comment')]
    public function createComment(Request $req, Connection $connexion, ManagerRegistry $doctrine): JsonResponse
    {
        if ($req->getMethod() == 'POST') {
            
            $this->em = $doctrine->getManager();
            $comment = new Comment();

            $this->setComment($req, $comment);

            $this->em->persist($comment);
            $this->em->flush();


            return new JsonResponse(['message' => 'Commentaire créé avec succès']);
        }

        return new JsonResponse(['message' => 'Erreur dans création de commentaire']);
    }

    //--------------------------------
    // Route to create a comment
    //--------------------------------
    #[Route('/comment-fixed/{idComment}')]
    public function commentFixed($idComment, Request $req, Connection $connexion, ManagerRegistry $doctrine): JsonResponse
    {
        $comment = $connexion->executeStatement("UPDATE comment SET isFixed = 1 WHERE idComment = $idComment");
        $comment = $connexion->executeStatement("UPDATE comment SET resolvedDate = NOW() WHERE idComment = $idComment");

        return $this->json($comment);
    }

    function setComment($req, $comment) {
        $comment->setReason($req->request->get('reason'));
        $comment->setContent($req->request->get('content'));
        $comment->setCreatedDate(new \DateTime());
        
        
        $idUser = $req->request->get('idUser');
        $user = $this->em->getRepository(User::class)->find($idUser);
        $comment->setUser($user);
        
    }
}
