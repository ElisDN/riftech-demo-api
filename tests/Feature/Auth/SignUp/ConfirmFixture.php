<?php

declare(strict_types=1);

namespace Test\Feature\Auth\SignUp;

use App\Model\User\Entity\User\ConfirmToken;
use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\User;
use App\Model\User\Entity\User\UserId;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class ConfirmFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User(
            UserId::next(),
            $now = new \DateTimeImmutable(),
            new Email('confirm@example.com'),
            'password_hash',
            new ConfirmToken('token', new \DateTimeImmutable('+1 day'))
        );

        $manager->persist($user);

        $expired = new User(
            UserId::next(),
            $now = new \DateTimeImmutable(),
            new Email('expired@example.com'),
            'password_hash',
            new ConfirmToken('token', new \DateTimeImmutable('-1 day'))
        );

        $manager->persist($expired);

        $manager->flush();
    }
}