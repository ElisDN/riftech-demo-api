<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type\Auction;

use App\Model\User\Entity\User\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class MemberEmailType extends StringType
{
    public const NAME = 'auction_member_email';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Email ? $value->getEmail() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new Email($value) : null;
    }

    public function getName(): string {
        return self::NAME;
    }
}