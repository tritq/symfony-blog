<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $authorRepository;

    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $blogPostRepository;

    /**
     * AdminController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->authorRepository = $this->entityManager->getRepository("App:Author");
        $this->blogPostRepository = $this->entityManager->getRepository("App:BlogPost");
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/author/create", name="author_create")
     */
    public function createAuthor(Request $request)
    {
        if ($this->getUser()) {
            if ($this->authorRepository->findOneByUsername($this->getUser()->getUserName())) {
                // Redirect to dashboard.
                $this->addFlash('error', 'Unable to create author, author already exists!');

                return $this->redirectToRoute('homepage');
            }
        }

        $author = new Author();
        if ($this->getUser()) {
            $author->setUsername($this->getUser()->getUserName());
        }

        $form = $this->createForm(AuthorFormType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($author);
            $this->entityManager->flush($author);

            $request->getSession()->set('user_is_author', true);
            $this->addFlash('success', 'Congratulations! You are now an author.');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('admin/create_author.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
