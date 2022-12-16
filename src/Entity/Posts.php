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
use App\Controller\PostImageController;
use App\Repository\PostsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
// use Vich\UploaderBundle\Entity\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
// use ApiPlatform\Action\PlaceholderAction;

#[ORM\Entity(repositoryClass: PostsRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            inputFormats: ['multipart' => ['multipart/form-data']], 
            deserialize: false,
            controller: PostImageController::class
           ),
        new Put(),
        new Delete(),

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

#[Vich\Uploadable]
class Posts extends AbstractController
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

    #[Vich\UploadableField(mapping: 'post_image', fileNameProperty: 'imageName', size: 'imageSize')]
    #[Groups(["Post:read", "Post:write"])]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'string')]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    #[Groups("Post:read")]
    public ?string $filePath = null;

    #[ORM\Column(type: 'integer')]
    private ?int $imageSize = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $updatedAt = null;

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

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }



}
