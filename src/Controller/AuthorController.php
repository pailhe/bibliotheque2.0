<?php


namespace App\Controller;


use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    /**
     * @Route("/author-form-insert", name="author_form_insert")
     */
    public function authorFormInsert(){
        return $this->render('author/authorFormInsert.html.twig');
    }

    /**
     * @Route("/author-insert", name="author_insert")
     */
    public function authorInsert(EntityManagerInterface $entityManager, Request $request)
    {

        $image = $request->request->get('image');
        $biographie = $request->request->get('biographie');
        $birthdate = $request->request->get('birthdate');
        $deathdate = $request->request->get('deathdate'); //nullable
        $firstname = $request->request->get('firstname');
        $name = $request->request->get('name');

        $author = new Author();

        $author->setImage($image)
                ->setBiographie($biographie)
                ->setBirthdate(new \DateTime($birthdate))
                ->setDeathdate(new \DateTime($deathdate))
                ->setFirstname($firstname)
                ->setName($name);

        $entityManager->persist($author);
        $entityManager->flush();

        return $this->render('author/authorInsert.html.twig',[
            'authorInsert' => $author
        ]);
    }

    /**
     * @Route("/author-delete/{id}", name="author_delete")
     */
    public function authorDelete(EntityManagerInterface $entityManager, AuthorRepository $authorRepository, $id){
        $author = $authorRepository->find($id);
        $entityManager->remove($author);
        $entityManager->flush();

        return $this->render('author/authorDelete.html.twig');
    }

    /**
     * @Route("author-form-update/{id}", name="author_form_update")
     */
    public function authorFormUpdate(AuthorRepository $authorRepository, $id){
        $author = $authorRepository->find($id);

        return $this->render('author/authorFormUpdate.html.twig',[
           'author' => $author
        ]);
    }

    /**
     * @Route("author-update/{id}", name="author_update")
     */
    public function authorUpdate(EntityManagerInterface $entityManager, AuthorRepository $authorRepository, Request
    $request, $id){
        $author = $authorRepository->find($id);

        $image = $request->request->get('image');
        $biographie = $request->request->get('biographie');
        $birthdate = $request->request->get('birthdate');
        $deathdate = $request->request->get('deathdate');
        $name = $request->request->get('name');
        $firstname = $request->request->get('firstname');

        $author ->setImage($image)
                ->setDeathdate($deathdate)
                ->setBiographie($biographie)
                ->setBirthdate(new \DateTime($birthdate))
                ->setDeathdate(new \DateTime($deathdate))
                ->setName($name)
                ->setFirstname($firstname);

        $entityManager->persist($author);
        $entityManager->flush();

        return $this->render('author/authorUpdate.html.twig');
    }

    /**
     * @Route("/author-insert-form", name="author_insert_form")
     */
    public function authorInsertForm(Request $request, EntityManagerInterface $entityManager){
        $author = new Author();
        $message = "";
        $authorForm = $this->createForm(AuthorType::class, $author);

        if($request->isMethod('Post')){
            $authorForm->handleRequest($request);
            if($authorForm->isValid()){
                $entityManager->persist($author);
                $entityManager->flush();
                $message = "l'auteur a bien été rajouté";
            }
        }


        $authorFormView = $authorForm->createView();

        return $this->render('author/authorInsertForm.html.twig',[
           'authorFormView' => $authorFormView,
            'message' => $message
        ]);
    }

    /**
     * @Route("/author-update-form/{id}", name="author_update_form")
     */
    public function authorUpdateForm(AuthorRepository $authorRepository, EntityManagerInterface $entityManager,
                                     Request $request, $id){
        $author = $authorRepository->find($id);

        $authorForm = $this->createForm(AuthorType::class, $author);

        if($request->isMethod('Post')){
            $authorForm->handleRequest($request);
            if($authorForm->isValid()){
                $entityManager->persist($author);
                $entityManager->flush();
            }
        }

        $authorFormView = $authorForm->createView();

        return $this->render('author/authorInsertForm.html.twig', [
            'authorFormView' => $authorFormView
        ]);
    }
}