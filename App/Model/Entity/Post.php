<?php declare(strict_types=1);
namespace App\Model\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Nette\InvalidArgumentException;
use Nette\Utils\Strings;

/**
 * @ORM\Entity()
 * @ORM\Table(name="board_post")
 */
class Post
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
     * @ORM\Column(type="text");
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(type="text", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", name="posted_at")
     */
    private $postedAt;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    public function __construct(string $type, string $title, string $content, DateTime $postedAt, bool $active, User $user)
    {
        if (Strings::length($title) > 255) {
            throw new InvalidArgumentException('Title is too long');
        }
        $this->title = $title;
        $this->content = $content;
        $this->postedAt = $postedAt;
        $this->active = $active;
        $this->user = $user;
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getPostedAt(): DateTime
    {
        return $this->postedAt;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
