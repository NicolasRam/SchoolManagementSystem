<?php

namespace App\Controller;

use App\Booking\BookingRequest;
use App\Booking\BookingRequestHandler;
use App\Entity\Booking;
use App\Entity\Member;
use App\Entity\PBook;
use App\Form\BookingRequestType;
use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backend/booking")
 */
class BookingController extends Controller
{
    /**
     * @Route("/", name="backend_booking_index", methods="GET")
     * @param BookingRepository $bookingRepository
     * @return Response
     */
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('backend/booking/index.html.twig', ['bookings' => $bookingRepository->findAll()]);
    }


    /**
     * @Route("/rent/{id}/", name="backend_booking_rent", methods="GET|POST|DELETE")
     * @param Request $request
     * @param BookingRequestHandler $bookingRequestHandler
     * @param PBook $pbook
     * @return Response
     */
    public function rent(Request $request, BookingRequestHandler $bookingRequestHandler, PBook $pbook): Response
    {


//        $booking = new Booking();

        $bookingRequest = new BookingRequest($pbook);

//
        $form = $this->createForm(BookingRequestType::class, $bookingRequest);

        //TO-DO: fournir le pbook au form

        //To-Do: gérer les dates et les ajouter au form

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            dd( $form );
            $this->getDoctrine()->getManager()->flush();

            $booking = $bookingRequestHandler->handle($bookingRequest);

            return $this->redirectToRoute('backend_booking_rent', ['id' => $booking->getId()]);
        }

        return $this->render('backend/booking/rent.html.twig', [
//            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="backend_booking_new", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingRequestType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($booking);
            $em->flush();

            return $this->redirectToRoute('backend_booking_index');
        }

        return $this->render('backend/booking/new.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_booking_show", methods="GET")
     */
    public function show(Booking $booking): Response
    {
        return $this->render('backend/booking/show.html.twig', ['booking' => $booking]);
    }

    /**
     * @Route("/{id}/edit", name="backend_booking_edit", methods="GET|POST")
     */
    public function edit(Request $request, Booking $booking): Response
    {
        $form = $this->createForm(BookingRequestType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('booking_edit', ['id' => $booking->getId()]);
        }

        return $this->render('backend/booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     *
     * @Route("/{id}", name="backend_booking_delete", methods="DELETE")
     * @param Request $request
     * @param Booking $booking
     * @return Response
     */
    public function delete(Request $request, Booking $booking): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($booking);
            $em->flush();
        }

        return $this->redirectToRoute('backend_booking_index');
    }
}