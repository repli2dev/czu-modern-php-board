<?php declare(strict_types=1);
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Nette\InvalidArgumentException;
use Nette\Security\Passwords;
use Nette\Utils\Strings;

/**
 * @ORM\Entity()
 * @ORM\Table(name="board_user")
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(length=255,unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $passwordHash;

    public function __construct(string $username, string $plainPassword)
    {
        if (Strings::length($username) > 255) {
            throw new InvalidArgumentException('Username is too long');
        }
        $this->username = $username;
        $this->passwordHash = Passwords::hash($plainPassword);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function matchesPassword(string $password): bool
    {
        return Passwords::verify($password, $this->passwordHash);
    }
}
