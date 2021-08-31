<?php

namespace App\Tests\Fonctional;

use Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class RegisterTest extends WebTestCase
{

    public function testIfResisterIsSuccessful(): void
    {
        $client = static::createClient();

        /** @var RouterInterface $router */
        $router = self::getContainer()->get('router');

        $crawler = $client->request(Request::METHOD_GET, $router->generate('app_register'));

        $form = $crawler->filter("form[name=registration_form]")->form([
            'registration_form[email]' => 'user+new@email.com',
            'registration_form[plainPassword]' => 'password1',
            'registration_form[nickname]' => 'user+new'
        ]);

        $client->submit($form);

        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        self::assertRouteSame('home_index');
    }
}
