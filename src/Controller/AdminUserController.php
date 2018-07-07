<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin/users", name="admin_users_")
 */
class AdminUserController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index(UserRepository $repo)
    {   
        $users = $repo->findAll();

        return $this->render('admin/user/index.html.twig', [
            'users' => $users
        ]);
    }
}
