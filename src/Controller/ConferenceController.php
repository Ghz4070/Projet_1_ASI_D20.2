<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Form\ConferenceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConferenceController extends AbstractController
{
    /**
     * @Route("/conference", name="conference")
     */
    public function index(Request $request)
    {
        $conference = new Conference();
        $form = $this->createForm(ConferenceType::class, $conference);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($conference);
            $entityManager->flush();
            $this->addFlash('success', 'la conference a bien ete cree !');
            return $this->redirectToRoute('home');
        }

        return $this->render('conference/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
