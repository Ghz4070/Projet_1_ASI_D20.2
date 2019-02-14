<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Repository\ConferenceRepository;
use App\Repository\VoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(VoteRepository $voteRepository)
    {
        $vote = $voteRepository->findAll();

        return $this->render('home/index.html.twig', [
            'vote' => $vote,
        ]);
    }

    /**
     * @Route("/conference/{id}", name="conferenceId")
     */
    public function conferenceId(Conference $conference){
        return $this->render('home/id.html.twig', [
            'conference' => $conference
        ]);
    }
}
