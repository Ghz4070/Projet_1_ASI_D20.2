<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UpdateUserType;
use App\Repository\UserRepository;
use App\Repository\VoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/user", name="user")
     */
    public function findAllUser(UserRepository $userRepository)
    {
        $user = $userRepository->findAll();

        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/admin/user/update/{id}", name="userUpdate")
     */
    public function updateUser(Request $request, User $user, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(UpdateUserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('user');
        }
        return $this->render('user/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/user/delete/{id}", name="deleteUser")
     * @ParamConverter("user", options={"mapping"={"id"="id"}})
     */
    public function deleteUser(User $user, VoteRepository $voteRepository, EntityManagerInterface $entityManager)
    {
        $votes = $voteRepository->findBy(['user' => $user]);
        if($votes !== null){
            foreach ($votes as $vote) {
                $vote->setUser(null);
                $entityManager->persist($vote);
                $entityManager->flush();
            }
        }
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute('home');
    }
}
