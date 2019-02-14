<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Entity\User;
use App\Entity\Vote;
use App\Repository\ConferenceRepository;
use App\Repository\VoteRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use mysql_xdevapi\Exception as ExceptionAlias;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Config\Definition\Exception\Exception;

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
        return $this->render('home/ConferenceId.html.twig', [
            'conference' => $conference
        ]);
    }
    /**
     * @Route("/conference/{id}/{note}", name="vote")
     */
    public function vote(Conference $conference,int $note, EntityManagerInterface $entityManager)
    {
        if($this->getUser() !== null){
            $userVote= $this->getUser()->getUserVote()->toArray();
            foreach ($userVote as $value){
                if($value->getConference()->getId() == $conference->getId()){
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
        } else{
            throw new Exception("User not connected");
        }

    }
}
