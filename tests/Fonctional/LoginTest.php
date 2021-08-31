<?php

namespace App\Tests\Fonctional;

use Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class LoginTest extends WebTestCase
{

    public function testIfLoginIsSuccessful(): void
    {
        $client = static::createClient();

        /** @var RouterInterface $router */
        $router = self::getContainer()->get('router');

        $crawler = $client->request(Request::METHOD_GET, $router->generate('app_login'));

        $form = $crawler->filter("form[name=login]")->form([
            'email' => 'admin@email.com',
            'password' => 'password1'
        ]);

        $client->submit($form);

        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        self::assertRouteSame('home_index');
    }

    /**
     * @param string $email
     * @param string $password
     * @dataProvider provideInvalidCredentials
     */
    public function testIfCredentialsAreInvalids(string $email, string $password): void
    {

        $client = static::createClient();

        /** @var RouterInterface $router */
        $router = self::getContainer()->get('router');

        $crawler = $client->request(Request::METHOD_GET, $router->generate('app_login'));

        $form = $crawler->filter("form[name=login]")->form([
            'email' => $email,
            'password' => $password
        ]);

        $client->submit($form);

        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        self::assertSelectorTextContains('form[name=login] div.alert', 'Identifiants invalides.');
    }

    public function testIfAccountIsSuspended(): void
    {
        $client = static::createClient();

        /** @var RouterInterface $router */
        $router = self::getContainer()->get('router');

        $crawler = $client->request(Request::METHOD_GET, $router->generate('app_login'));

        $form = $crawler->filter("form[name=login]")->form([
            'email' => 'user+suspended@email.com',
            'password' => 'password1'
        ]);

        $client->submit($form);

        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        self::assertSelectorTextContains('form[name=login] div.alert', 'Votre compte est suspendu.');
    }


    public function provideInvalidCredentials(): Generator
    {
        yield ['email1@gmail.com', 'password1'];
        yield ['admin@email.com', 'wrong'];
    }
}
