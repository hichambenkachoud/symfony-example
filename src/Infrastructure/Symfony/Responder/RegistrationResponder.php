<?php

namespace App\Infrastructure\Symfony\Responder;

use App\Domain\User\UserInterface\Responder\RegistrationResponderInterface;
use App\Domain\User\UserInterface\ViewModel\RegistrationViewModel;
use App\Infrastructure\Symfony\Handler\RegistrationHandler;
use App\Infrastructure\Symfony\Security\SecurityUser;
use App\Infrastructure\Symfony\Security\WebAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Twig\Environment;

class RegistrationResponder implements RegistrationResponderInterface
{

    private UserAuthenticatorInterface $guardAuthenticator;
    private WebAuthenticator $webAuthenticator;
    private RequestStack $request;
    private Environment $twig;
    private RegistrationHandler $handler;

    public function __construct(
        UserAuthenticatorInterface $guardAuthenticator,
        WebAuthenticator $webAuthenticator,
        RequestStack $request,
        Environment $twig,
        RegistrationHandler $handler
    ) {
        $this->guardAuthenticator = $guardAuthenticator;
        $this->webAuthenticator = $webAuthenticator;
        $this->request = $request;
        $this->twig = $twig;
        $this->handler = $handler;
    }


    public function render(): Response
    {
        return new Response(
            $this->twig->render('registration.html.twig', [
                'form' => $this->handler->getForm()->createView()
            ])
        );
    }

    public function authenticate(RegistrationViewModel $viewModel): Response
    {

        return $this->guardAuthenticator->authenticateUser(
            new SecurityUser(
                $viewModel->getUser()->getEmail(),
                $viewModel->getUser()->getPassword()
            ),
            $this->webAuthenticator,
            $this->request->getCurrentRequest()
        );
    }
}
