<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 13/02/2019
 * Time: 13:54
 */

namespace App\AliceBundleMethod;


use App\Entity\User;
use Fidry\AliceDataFixtures\ProcessorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserProcessor implements ProcessorInterface
{

    protected $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Processes an object before it is persisted to DB.
     * @param object $object
     */
    public function preProcess(string $id,$object):void
    {
        if(!$object instanceof User){
            return;
        }
        //dd($object->getPassword());
        $password = $this->encoder->encodePassword($object, $object->getPassword());
        $object->setPassword($password);
    }


    /**
     * Processes an object after it is persisted to DB.
     *
     * @param string $id Fixture ID
     * @param object $object
     */
    public function postProcess(string $id, $object): void
    {
        // TODO: Implement postProcess() method.
    }
}