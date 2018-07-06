<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Form\BookingType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class BookingController extends Controller
{


    private function isBookableDates($booking, $ad) {
        $notAvailableDays = $ad->getNotAvailableDays();
        $bookingDays = $booking->getDays();

        $formatToDay = function($day) {
            return $day->format('Y-m-d');
        };

        $days           = array_map($formatToDay, $bookingDays);
        $notAvailable   = array_map($formatToDay, $notAvailableDays);

        foreach($days as $day) {
            if(array_search($day, $notAvailable) !== false) return false;
        }

        return true;
    }

    /**
     * @Route("/ad/{slug}/book", name="booking")
     * @Security("is_granted('ROLE_USER')")
     */
    public function book(Ad $ad, string $slug, Request $request, ObjectManager $manager)
    {
        $booking = new Booking();

        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if(!$this->isBookableDates($booking, $ad)) {
                $this->addFlash(
                    'danger',
                    "Désolé, mais les dates que vous avez choisi ne sont pas disponibles :'(, merci d'en choisir d'autres ..."
                );
            } else {
                $booking->setAd($ad)
                        ->setBooker($this->getUser());

                $manager->persist($booking);
                $manager->flush();

                return $this->redirectToRoute("booking_show", ['id' => $booking->getId(), 'withAlert' => true]);
            }
        }

        return $this->render('booking/book.html.twig', [
            'ad' => $ad,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/booking/{id}", name="booking_show")
     */
    public function success($id, Booking $booking, Request $request) {
        return  $this->render('booking/show.html.twig', [
            'booking' => $booking
        ]);
    }
}
