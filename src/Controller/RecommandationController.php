<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;
use App\Entity\Borrow;
use App\Entity\User;
use app\Entity\Genre;
use App\Service\Recomandation;
use Doctrine\Persistence\ManagerRegistry;

class RecommandationController extends AbstractController
{
    private $em = null;
    private $borrows=[];
    private $genres=[];
    private $authors=[];
    private $amountGenres;
    private $amountAuthors;

    #[Route('/recommandation', name: 'app_recommandation')]
    public function index(ManagerRegistry $doctrine,Connection $connexion): JsonResponse
    {
        $idUser=1;
        $this->em = $doctrine->getManager();
        $user = $this->em->getRepository(User::class)->find($idUser);
        $this->borrows = $this->em->getRepository(Borrow::class)->findBy(['user'=>$idUser]);
        $this->genres = $this->em->getRepository(Genre::class)->findAll();
        $this->amountGenres = $connexion->fetchAssociative("SELECT DISTINCT idGenre FROM borrows b INNER JOIN books g ON b.idBook = g.idBook WHERE idUser = $idUser");
        $this->amountAuthors = $connexion->fetchAssociative("SELECT DISTINCT idAuthor FROM borrows b INNER JOIN books g ON b.idBook = g.idBook WHERE idUser = $idUser");
        $recommandedGenres = $this->RecommandedGenres();
        $recommandedAuthors= $this->RecommandedAuthors();
    

        $qb = $this->em->createQueryBuilder();
                 $qb->select('b')
                    ->from('App\Entity\Book','b')
                    ->innerJoin('b.genre','genre')
                    ->innerJoin('b.author','author')
                    ->where('genre.idGenre IN (:listGenre)')
                    ->orWhere('author.idAuthor IN (:listAuthor)')
                    ->distinct()
                    ->setParameter('listGenre',$recommandedGenres)
                    ->setParameter('listAuthor',$recommandedAuthors); 
        $recomandedBooks=$qb->getQuery()->getResult();
        

        return $this->json([
            'user'=>$user,
            'borrows'=>$this->borrows,
            'genre'=>$this->genres,
            'recomended Genre' => $recommandedGenres,
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/RecommandationController.php',
        ]);
    }


    function RecommandedGenres()
    {
        $recommandedGenres = [];
        $counter=0;

        if($this->borrows){
            foreach($this->genres as $genre){
                $counter=0;
                foreach($this->borrows as $borrow){
                    if($genre->getIdGenre() == $borrow->getBook()->getGenre()->getIdGenre()){     
                        $counter++;
                    }
                }
                if($counter>=(sizeof($this->borrows)/sizeof($this->amountGenres))){
                    $recommandedGenres[] = $genre;
                }
            }
        }
        return $recommandedGenres;
    }

    function RecommandedAuthors()
    {
        $recommandedAuthors = [];
        $counter=0;

        if($this->borrows){
            foreach($this->authors as $author){
                $counter=0;
                foreach($this->borrows as $borrow){
                    if($author->getIdAuthor() == $borrow->getBook()->getAuthor()->getIdAuthor()){     
                        $counter++;
                    }
                }
                if($counter>=(sizeof($this->borrows)/sizeof($this->amountAuthors))){
                    $recommandedAuthors[] = $authors;
                }
            }
        }
        return $recommandedAuthors;
    }
}
