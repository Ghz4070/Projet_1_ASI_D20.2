<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function editProfileUser()
    {

        return $this->render('profile/editProfileUser.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }
}
