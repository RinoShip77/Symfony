<?php

namespace App\Controller;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");
header("Allow: *");

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
use App\Tools;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class RecommandationController extends AbstractController
{
    private $em = null;
    private $borrows=[];
    private $genres=[];
    private $authors=[];
    private $amountGenres=[];
    private $amountAuthors;

    #[Route('/recommandation/{idUser}', name: 'app_recommandation')]
    public function index($idUser,ManagerRegistry $doctrine,Connection $connexion): JsonResponse
    {   
        $this->em = $doctrine->getManager();
        $user = $this->em->getRepository(User::class)->find($idUser);
        $this->borrows = $this->em->getRepository(Borrow::class)->findBy(['user'=>$idUser]);

        if(count($this->borrows)<=6){
            return $this->json([]);
        }

        $this->genres = $this->em->getRepository(Genre::class)->findAll();
        $this->amountGenres = $connexion->fetchAssociative("SELECT COUNT(DISTINCT idGenre) FROM borrows b INNER JOIN books g ON b.idBook = g.idBook WHERE idUser = $idUser");
        $this->amountAuthors = $connexion->fetchAssociative("SELECT COUNT(DISTINCT idAuthor) FROM borrows b INNER JOIN books g ON b.idBook = g.idBook WHERE idUser = $idUser");

        $recommandedGenres = $this->RecommandedGenres();
        $recommandedAuthors= $this->RecommandedAuthors();

        $books=[];
        foreach($this->borrows as $borrow){
            array_push($books,$borrow->getBook());
        }
    

        $qb = $this->em->createQueryBuilder();
                 $qb->select('b')
                    ->from('App\Entity\Book','b')
                    ->innerJoin('b.genre','genre')
                    ->innerJoin('b.author','author')
                    ->where('genre.idGenre IN (:listGenre)')
                    ->orWhere('author.idAuthor IN (:listAuthor)')
                    ->andWhere('b.isRecommended = TRUE')
                    ->andWhere('b.idBook NOT IN (:books)')
                    ->distinct()
                    ->setParameter('books',$books)
                    ->setParameter('listGenre',$recommandedGenres)
                    ->setParameter('listAuthor',$recommandedAuthors); 
        $recomandedBooks=$qb->getQuery()->getResult();

        if(count($recomandedBooks)<10){
            $qb = $this->em->createQueryBuilder();
            $qb->select('b')
               ->from('App\Entity\Book','b')
               ->innerJoin('b.genre','genre')
               ->innerJoin('b.author','author')
               ->where('genre.idGenre IN (:listGenre)')
               ->orWhere('author.idAuthor IN (:listAuthor)')
               ->andWhere('b.idBook NOT IN (:books)')
               ->distinct()
               ->setParameter('books',$books)
               ->setParameter('listGenre',$recommandedGenres)
               ->setParameter('listAuthor',$recommandedAuthors); 
            array_push($recomandedBooks,...$qb->getQuery()->getResult());
        }

        if(count($recomandedBooks)<10){
            $qb = $this->em->createQueryBuilder();
            $qb->select('b')
               ->from('App\Entity\Book','b')
               ->where('b.isRecommended = TRUE')
               ->andWhere('b.idBook NOT IN (:books)')
               ->setParameter('books',$books)
               ->distinct();
            array_push($recomandedBooks,...$qb->getQuery()->getResult());
        }

        $jsonBook=[];
        $jsonResponse=[];
        foreach($recomandedBooks as $book){
            $jsonBook['idBook']=$book->getIdBook();
            $jsonBook['title']=$book->getTitle();
            $jsonBook['description']=$book->getDescription();
            $jsonBook['cover']=$book->getCover();
            $jsonBook['isRecommended']=$book->getIsRecommended();
            $jsonResponse[]=$jsonBook;

        }

        //tools::logmsg($recomandedBooks);
        return new JsonResponse($jsonResponse,);
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
                //var_dump($counter);
                //var_dump((sizeof($this->borrows)/sizeof($this->amountGenres)));
                if($counter>=(sizeof($this->borrows)/$this->amountGenres['COUNT(DISTINCT idGenre)'])){
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
                if($counter>=(sizeof($this->borrows)/$this->amountAuthors['COUNT(DISTINCT idAuthor)'])){
                    $recommandedAuthors[] = $authors;
                }
            }
        }
        return $recommandedAuthors;
    }
}
