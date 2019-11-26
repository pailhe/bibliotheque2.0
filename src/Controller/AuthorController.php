<?php


namespace App\Controller;


use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    /**
     * @Route("/author-list", name="author_list")
     */
    public function authorList(AuthorRepository $authorRepository){
        $authorList = $authorRepository->findAll();
        return $this->render('author/authorList.html.twig', [
           'authorList' => $authorList
        ]);
    }

    /**
     * @Route("/author-show/{id}", name="author_show")
     */
    public function authorShow(AuthorRepository $authorRepository, $id){
        $authorShow = $authorRepository->find($id);
        return $this->render('author/authorShow.html.twig', [
           'authorShow' => $authorShow,
        ]);
    }

    /**
     * @Route("/author-bio", name="author_bio")
     */
    public function getByBio(AuthorRepository $authorRepository, Request $request){
        $word=$request->query->get('word');
        $authorByBio = $authorRepository->getByBio($word);
        return $this->render('author/authorList.html.twig',[
            'authorList' => $authorByBio
        ]);



    }
}