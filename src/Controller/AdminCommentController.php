<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin/comments", name="admin_comments_")
 */
class AdminCommentController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index(CommentRepository $repo)
    {
        $comments = $repo->findAll();
        return $this->render('admin/comment/index.html.twig', [
            'comments' => $comments
        ]);
    }
}
