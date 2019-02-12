<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UpdateUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class AdminController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function findAllUser(UserRepository $userRepository)
    {
        $user = $userRepository->findAll();

        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/user/{id}", name="userId")
     */
    public function findUserById(User $user)
    {
        return $this->render('user/idUser.html.twig', [
            'user'=> $user
        ]);
    }

    /**
     * @Route("/user/update/{id}", name="userUpdate")
     */
    public function updateUser(Request $request,User $user, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(UpdateUserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('user/update.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/delete/{id}", name="deleteUser")
     * @ParamConverter("user", options={"mapping"={"id"="id"}})
     */
    public function deleteUser(User $user, EntityManagerInterface $entityManager){
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute('home');
    }
}
