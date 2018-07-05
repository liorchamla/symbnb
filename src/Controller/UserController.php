<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    /**
     * @Route("/user/{slug}", name="user_profile")
     */
    public function userProfile(User $user, string $slug)
    {
        return $this->render('user/index.html.twig', [
            'user' => $user
        ]);
    }
}
