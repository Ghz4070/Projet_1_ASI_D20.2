<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 15/02/2019
 * Time: 10:05
 */

namespace App\AliceBundleMethod;


use Faker\Generator;
use Faker\Provider\Base as BaseProvider;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CustomFixtureProvider extends BaseProvider
{
    private $passwordEncoder;

    public function __construct(Generator $generator ,UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct($generator);
        $this->passwordEncoder= $passwordEncoder;
    }

    public function passwordEncode(User $user, $password){

        $encode = $this->passwordEncoder->encodePassword($user, $password);
        return $encode;
    }

}