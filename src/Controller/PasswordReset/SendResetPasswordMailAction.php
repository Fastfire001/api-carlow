<?php

namespace App\Controller\PasswordReset;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\MailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SendResetPasswordMailAction extends AbstractController
{
    /** @var MailService */
    private $mailService;

    /** @var UserRepository */
    private $userRepository;

    public function __construct(
        MailService $mailService,
        UserRepository $userRepository
    )
    {
        $this->mailService = $mailService;
        $this->userRepository = $userRepository;
    }

    public function __invoke(Request $request, string $email): Response
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);
        if ($user instanceof User) {
            return $this->json($this->mailService->sendPasswordResetMail($user));
        } else {
            return $this->json('User not found', 400);
        }
    }
}