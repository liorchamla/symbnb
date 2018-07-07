<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdminAdType;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
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

    /**
     * @Route("/{id}", name="edit")
     */
    public function edit(Ad $ad, $id, Request $request, ObjectManager $manager) {
        $form = $this->createForm(AdminAdType::class, $ad);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->addFlash(
                'success',
                "L'annonce <strong>{$ad->getTitle()}</strong> a bien été modifiée !"
            );
        }

        return $this->render('admin/ad/edit.html.twig', [
            'ad' => $ad,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/delete", name="delete")
     */
    public function delete(Ad $ad, $id, ObjectManager $manager) {
        $manager->remove($ad);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'annonce <strong>{$ad->getTitle()}</strong> a bien été supprimée, ainsi que toutes ses réservations et commentaires !"
        );

        return $this->redirectToRoute('admin_ads_index');
    } 
}
