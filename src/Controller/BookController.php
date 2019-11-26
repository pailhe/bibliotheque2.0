<?php


namespace App\Controller;


use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/book-list", name="book_list")
     */
    public function bookList(BookRepository $bookRepository){
        $bookList = $bookRepository->findAll();
        return $this->render('book/bookList.html.twig',[
            'bookList' => $bookList
        ]);
    }

    /**
     * @Route("/book-show/{id}", name="book_show")
     */
    public function bookShow(BookRepository $bookRepository, $id){
        $bookShow = $bookRepository->find($id);
        return $this->render('book/bookShow.html.twig',[
            'bookShow' => $bookShow
        ]);
    }

    /**
     * @Route("/books-by-style", name="books_by_style")
     */
    public function getByStyle(BookRepository $bookRepository, Request $request){
        $word=$request->query->get('word');
        $booksByStyle = $bookRepository->getByStyle($word);
        return $this->render('book/bookList.html.twig',[
           'bookList' => $booksByStyle
        ]);
    }
}