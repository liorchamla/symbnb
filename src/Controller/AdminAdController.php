<?php

namespace App\Controller;

use App\Repository\AdRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin/ads", name="admin_ads_")
 */
class AdminAdController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index(AdRepository $repo)
    {
        $ads = $repo->findAll();

        return $this->render('admin/ad/index.html.twig', [
            'ads' => $ads
        ]);
    }
}
