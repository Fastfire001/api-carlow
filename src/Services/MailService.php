<?php

namespace App\Services;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;

class MailService
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var Swift_Mailer */
    private $mailer;

    /** @var Environment */
    private $twig;

    public function __construct(
        EntityManagerInterface $entityManager,
        Swift_Mailer $mailer,
        Environment $environment
    )
    {
        $this->em = $entityManager;
        $this->mailer = $mailer;
        $this->twig = $environment;
    }

    private function sendMail(string $to, string $subject, string $body): int
    {
        $message = new Swift_Message($subject);
        $message->setFrom('carlow.pfe@gmail.com')
            ->setTo($to)
            ->setBody($body, 'text/html');

        return $this->mailer->send($message);
    }

    public function sendPasswordResetMail(User $user): int
    {
        $user->setResetToken(sha1(mt_rand(1, 90000) . '7df54xcw'));
        $this->em->flush();
        $body = $this->twig->render('emails/password_forgot.html.twig', ['user' => $user]);
        return $this->sendMail($user->getEmail(), 'Mot de passe oublié', $body);
    }
}