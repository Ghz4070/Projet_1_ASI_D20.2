<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Form\ConferenceType;
use App\Repository\VoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConferenceController extends AbstractController
{
    /**
     * @Route("/admin/conference", name="conference")
     */
    public function create(Request $request)
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

    /**
     * @Route("/admin/conference/edit/{id}", name="edit_conference")
     */
    public function edit(Request $request, Conference $conference = null)
    {
        if (!$conference) {
            $conference = new conference();
        }
        $form = $this->createForm(ConferenceType::class, $conference);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($conference);
            $entityManager->flush();
            $this->addFlash('green', 'Modification enregistrer !');
            return $this->redirectToRoute('home');
        }

        return $this->render('conference/edit_conference.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/conference/topDix", name="topDix")
     */
    public function topDix(VoteRepository $voteRepository)
    {
        $conferences = $voteRepository->averageTopDix();

        return $this->render('conference/topDix.html.twig', array(
            'conferences' => $conferences
        ));
    }


    /**
     * @Route("/admin/conference/remove/{id}", name="remove_conference")
     * @ParamConverter("conference", options={"mapping"={"id"="id"}})
     */
    public function delete(EntityManagerInterface $entityManager, Conference $conference)
    {
        $entityManager->remove($conference);
        $entityManager->flush();
        $this->addFlash('notice', 'Element supprimer !');
        return $this->redirectToRoute('home');
    }
}
