<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\PBook;
use App\Form\PBookType;
use App\Repository\PBookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backend/pbook")
 */
class PBookController extends Controller
{
    /**
     * @Route("/", name="backend_pbook_index", methods="GET")
     * @param PBookRepository $pbookRepository
     * @return Response
     */
    public function index(PBookRepository $pbookRepository): Response
    {
        return $this->render('backend/pbook/index.html.twig', ['pbooks' => $pbookRepository->findAll()]);
    }

    /**
     * @Route("/", name="backend_pbook_list", methods="GET")
     * @param PBookRepository $pbookRepository
     * @param Book $book
     * @return Response
     */
    public function list(PBookRepository $pbookRepository, Book $book): Response
    {

        $pbooks = $book->getPBooks();



        return $this->render('backend/pbook/list.html.twig', ['pbooks' => $pbooks]);
    }


    /**
     * @Route("/new", name="pbook_new", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $pbook = new PBook();
        $form = $this->createForm(PBookType::class, $pbook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pbook);
            $em->flush();

            return $this->redirectToRoute('backend_pbook_index');
        }

        return $this->render('backend/pbook/new.html.twig', [
            'pbook' => $pbook,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pbook_show", methods="GET")
     */
    public function show(PBook $pbook): Response
    {
        return $this->render('backend/pbook/show.html.twig', ['pbook' => $pbook]);
    }

    /**
     * @Route("/{id}/edit", name="pbook_edit", methods="GET|POST")
     */
    public function edit(Request $request, PBook $pbook): Response
    {
        $form = $this->createForm(PBookType::class, $pbook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pbook_edit', ['id' => $pbook->getId()]);
        }

        return $this->render('backend/pbook/edit.html.twig', [
            'pbook' => $pbook,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pbook_delete", methods="DELETE")
     */
    public function delete(Request $request, PBook $pbook): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pbook->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pbook);
            $em->flush();
        }

        return $this->redirectToRoute('backend_pbook_index');
    }
}
