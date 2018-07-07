<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminDashboardController extends Controller
{
    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function index(ObjectManager $manager)
    {   
        $users = $manager->createQuery('SELECT COUNT(u.id) FROM App\Entity\User u')->getSingleScalarResult();
        $ads = $manager->createQuery('SELECT COUNT(a.id) FROM App\Entity\Ad a')->getSingleScalarResult();
        $bookings = $manager->createQuery('SELECT COUNT(b.id) FROM App\Entity\Booking b')->getSingleScalarResult();

        $bestAds = $manager->createQuery('SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName, u.picture FROM App\Entity\Comment c JOIN c.ad a JOIN a.owner u GROUP BY a.id ORDER BY note DESC')->setMaxResults(5)->getResult();

        $worstAds = $manager->createQuery('SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName, u.picture FROM App\Entity\Comment c JOIN c.ad a JOIN a.owner u GROUP BY a.id ORDER BY note ASC')->setMaxResults(5)->getResult();

        return $this->render('admin/dashboard/index.html.twig', [
            'stats' => compact('users', 'ads', 'bookings', 'bestAds', 'worstAds')
        ]);
    }
}
