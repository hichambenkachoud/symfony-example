<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\WebAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Twig\Environment;

/**
 * @Route("/register", name="app_register")
 */
class RegistrationController
{

    private UserPasswordHasherInterface $encoder;
    private FormFactoryInterface $formFactory;
    private Environment $environment;
    private UserAuthenticatorInterface $authenticator;
    private EntityManagerInterface $entityManager;

    public function __construct(
        UserPasswordHasherInterface $encoder,
        FormFactoryInterface $formFactory,
        Environment $environment,
        UserAuthenticatorInterface $authenticator,
        EntityManagerInterface $entityManager
    ) {
        $this->encoder = $encoder;
        $this->formFactory = $formFactory;
        $this->environment = $environment;
        $this->authenticator = $authenticator;
        $this->entityManager = $entityManager;
    }

    public function __invoke(Request $request, WebAuthenticator $webAuthenticator): Response
    {
        $user = new User();
        $form = $this->formFactory->create(RegistrationFormType::class, $user)->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($this->encoder->hashPassword($user, $form->get('plainPassword')->getData()));

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->authenticator->authenticateUser(
                $user,
                $webAuthenticator,
                $request
            );
        }

        return new Response(
            $this->environment ->render('registration.html.twig', [
                'form' => $form->createView()
            ])
        );
    }
}
