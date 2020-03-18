<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ApiController extends AbstractController
{
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $json = json_decode($request->getContent(), true);
        $errors = [];
        $user = new User();

        if (!empty($json['email']) && filter_var($json['email'], FILTER_VALIDATE_EMAIL)) {
            $user->setEmail($json['email']);
        } else {
            $errors[] = 'email';
        }

        if (!empty($json['firstname']) && strlen($json['firstname']) >= 2) {
            $user->setFirstname($json['firstname']);
        } else {
            $errors[] = 'firstname';
        }

        if (!empty($json['lastname']) && strlen($json['lastname']) >= 2) {
            $user->setLastname($json['lastname']);
        } else {
            $errors[] = 'lastname';
        }

        if (!empty($json['password']) && strlen($json['password']) >= 6) {
            if (!empty($json['password_repeat']) && $json['password'] === $json['password_repeat']) {
                $pass = $encoder->encodePassword($user, $json['password']);
                $user->setPassword($pass);
            } else {
                $errors[] = 'password_repeat';
            }
        } else {
            $errors[] = 'password';
        }

        if (empty($errors)) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->json($user);
        } else {
            return $this->json($errors);
        }

    }
}
