<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin/bookings", name="admin_bookings_")
 */
class AdminBookingController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index(BookingRepository $repo)
    { 
        $bookings = $repo->findAll();

        return $this->render('admin/booking/index.html.twig', [
            'bookings' => $bookings
        ]);
    }
}
