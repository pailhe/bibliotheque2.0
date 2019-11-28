<?php


namespace App\Controller;


use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    /**
     * @Route("/book-form-insert", name="book_form_insert")
     */
    public function bookFormInsert(){
        return $this->render('book/bookFormInsert.html.twig');
    }

    /**
     * @Route("/book-insert", name="book_insert")
     */
    public function bookInsert(EntityManagerInterface $entityManager, Request $request){
        $image = $request->request->get('image');
        $inStock = $request->request->get('inStock');
        $nbPages = $request->request->get('nbPages');
        $style = $request->request->get('style');
        $title = $request->request->get('title');

        $book = new Book();
        $book->getId();
        $book->setImage($image);
        $book->setInStock($inStock);
        $book->setNbPages($nbPages);
        $book->setStyle($style);
        $book->setTitle($title);

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->render('book/bookInsert.html.twig',[
            'bookInsert' => $book
        ]);
    }

    /**
     * @Route("/book-delete/{id}", name="book_delete")
     */
    public function bookDelete(EntityManagerInterface $entityManager, BookRepository $bookRepository, $id){
        $book = $bookRepository->find($id);
        $entityManager->remove($book);
        $entityManager->flush();

        return $this->render('book/bookDelete.html.twig');
    }

    /**
     * @Route("/book-form-update/{id}", name="book_form_update")
     */
    public function bookFormUpdate(BookRepository $bookRepository, $id){
        $book = $bookRepository->find($id);


        return $this->render('book/bookFormUpdate.html.twig', [
            'book' => $book
        ]);
    }

    /**
     * @Route("/book-update/{id}", name="book_update")
     */
    public function bookUpdate(EntityManagerInterface $entityManager, BookRepository $bookRepository,
                               Request $request, $id){
        $book = $bookRepository->find($id);

        $image = $request->request->get('image');
        $inStock = $request->request->get('inStock');
        $nbPages = $request->request->get('nbPages');
        $style = $request->request->get('style');
        $title = $request->request->get('title');


        $book->setImage($image)
            ->setTitle($title)
            ->setStyle($style)
            ->setNbPages($nbPages)
            ->setInStock($inStock);

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->render('book/bookUpdate.html.twig');
    }

    /**
     * @Route("/book-insert-form", name="book_insert_form")
     */
    public function bookInsertForm(EntityManagerInterface $entityManager, Request $request){
        //je crée un nouveau Book,
        //en créant
        $book = new Book();
        $message = "";
        $bookForm = $this->createForm(BookType::class, $book);

        if($request->isMethod('Post')){
            $bookForm->handleRequest($request);
            if($bookForm->isValid()){
                $entityManager->persist($book);
                $entityManager->flush();
                $message = "Le livre a bien été rajouté";
            }
        }

        $bookFormView = $bookForm->createView();

        return $this->render('book/bookInsertForm.html.twig',[
           'bookFormView' => $bookFormView,
            'message' => $message
        ]);
    }

    /**
     * @Route("/book-update-form/{id}", name="book_update_form")
     */
    public function bookUpdateForm(BookRepository $bookRepository, Request $request, $id,
                                   EntityManagerInterface $entityManager){
        $book = $bookRepository->find($id);

        $bookForm = $this->createForm(BookType::class, $book);

        if($request->isMethod('Post')){
            $bookForm->handleRequest($request);
            if($bookForm->isValid()){
                $entityManager->persist($book);
                $entityManager->flush();
            }
        }

        $bookFormView=$bookForm->createView();

        return $this->render('book/bookInsertForm.html.twig', [
            'bookFormView' => $bookFormView
        ]);
    }
}