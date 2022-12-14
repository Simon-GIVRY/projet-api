<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\PostsRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;


#[ORM\Entity(repositoryClass: PostsRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Delete()
    ],
    normalizationContext:["groups" => ["Post:read"]],
    denormalizationContext:["groups" => ["Post:write"]]

)]
#[ApiFilter(SearchFilter::class, properties:[
    "TextContent" => "partial", 
    "tags" => "partial",
    "postOwner" => "exact",
    "postOwner.username" => "partial"
    
])]
#[ApiFilter(BooleanFilter::class, properties:["isPublished"])]

class Posts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["Post:read", "Post:write", "User:read"])]
    private ?string $TextContent = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["Post:read", "Post:write", "User:read"])]
    private ?string $urlLinkedMedia = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["Post:read", "Post:write", "User:read"])]
    private ?string $tags = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["Post:read", "User:read"])]
    private ?int $likes = null;

    #[ORM\Column]
    #[Groups(["Post:read", "User:read"])]
    private ?bool $isPublished = false;

    #[ORM\ManyToOne(targetEntity:"User", inversedBy: 'posts',cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    #[NotBlank()]
    #[Groups(["Post:read", "Post:write", "User:read"])]
    private ?User $postOwner = null;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getTextContent(): ?string
    {
        return $this->TextContent;
    }

    public function setTextContent(?string $TextContent): self
    {
        $this->TextContent = $TextContent;

        return $this;
    }

    public function getUrlLinkedMedia(): ?string
    {
        return $this->urlLinkedMedia;
    }

    public function setUrlLinkedMedia(?string $urlLinkedMedia): self
    {
        $this->urlLinkedMedia = $urlLinkedMedia;

        return $this;
    }

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(?string $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(?int $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function isIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getPostOwner(): ?User
    {
        return $this->postOwner;
    }

    public function setPostOwner(?User $postOwner): self
    {
        $this->postOwner = $postOwner;

        return $this;
    }
}
