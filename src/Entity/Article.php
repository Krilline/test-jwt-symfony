<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{

    use RessourceId;
    use TimeStapable;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"article:read", "article:write"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     *
     * @Groups({"article:read", "article:write"})
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Groups({"article:read"})
     */
    private $author;

    public function __construct()
    {
        $this->createdAt = New \DateTime();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
