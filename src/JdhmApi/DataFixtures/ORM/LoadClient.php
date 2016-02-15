<?php

namespace JdhmApi\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JdhmApi\Entity\Client;

class LoadClient implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $client = new Client();
        $client->setFirstName('Pierre-Henri');
        $client->setLastName('Bourdeau');
        $client->setEmail('phbasic@gmail.com');
        $client->setDateOfBirth(new \DateTime("now"));

        $manager->persist($client);
        $manager->flush();
    }
}
