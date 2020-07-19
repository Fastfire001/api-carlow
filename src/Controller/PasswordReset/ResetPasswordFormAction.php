<?php

namespace App\Controller\PasswordReset;

use App\Entity\User;
use App\Form\PasswordResetType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordFormAction extends AbstractController
{

    /** @var UserRepository */
    private $userRepository;

    /** @var UserPasswordEncoderInterface */
    private $encoder;

    public function __construct(
        UserRepository $userRepository,
        UserPasswordEncoderInterface $encoder
    )
    {
        $this->userRepository = $userRepository;
        $this->encoder = $encoder;
    }

    public function __invoke(Request $request): Response
    {
        $resetToken = $request->query->get('token');
        $user = $this->userRepository->findOneBy(['resetToken' => $resetToken]);
        if (!($user instanceof User)) {
            return $this->render('password_reset/error.html.twig');
        }

        $form = $this->createForm(PasswordResetType::class);
        $form->setData(['reset_token' => $user->getResetToken()]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $form = $form->getData();
            $hash = $this->encoder->encodePassword($user, $form['password']);
            $user->setPassword($hash)
                ->setResetToken(null);
            $this->getDoctrine()->getManager()->flush();

            return $this->render('password_reset/success.html.twig');
        }

        return $this->render('password_reset/form.html.twig', ['form' => $form->createView()]);
    }
}