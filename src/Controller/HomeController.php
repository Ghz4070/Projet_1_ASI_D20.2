<?php

namespace App\Controller;

use App\Repository\ConferenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ConferenceRepository $conferenceRepository)
    {
        $conference = $conferenceRepository->findAll();

        return $this->render('home/index.html.twig', [
            'conference' => $conference,
        ]);
    }
}
