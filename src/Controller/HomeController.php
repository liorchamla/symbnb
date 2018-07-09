<?php

namespace App\Controller;

use App\Repository\AdRepository;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index(UserRepository $userRepo, AdRepository $adRepo)
    {
        $starUsers = $userRepo->findStarUsers();
        $starAds = $adRepo->findAllWithPagination(1, 3, 'avgRatings', 'DESC');

        return $this->render('home/index.html.twig', [
            'starUsers' => $starUsers,
            'starAds' => $starAds
        ]);
    }
}
