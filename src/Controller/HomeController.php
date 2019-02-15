<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Entity\Vote;
use App\Repository\VoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Config\Definition\Exception\Exception;


class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function showConf(VoteRepository $voteRepository, Request $request)
    {
        $vote = $voteRepository->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $vote, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return $this->render('home/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/conference/{id}", name="conferenceId")
     */
    public function conferenceId(Conference $conference)
    {
        return $this->render('home/ConferenceId.html.twig', [
            'conference' => $conference
        ]);
    }

    /**
     * @Route("/conference/{id}/{note}", name="vote")
     */
    public function vote(Conference $conference, int $note, EntityManagerInterface $entityManager)
    {
        if ($this->getUser() !== null) {
            $userVote = $this->getUser()->getUserVote()->toArray();
            foreach ($userVote as $value) {
                if ($value->getConference()->getId() == $conference->getId()) {
                    throw new Exception("User has already vote ");
                }
            }
            $votes = new Vote();
            $votes->setUser($this->getUser());
            $votes->setConference($conference);
            $votes->setScore($note);

            $entityManager->persist($votes);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        } else {
            throw new Exception("User not connected");
        }

    }
}
