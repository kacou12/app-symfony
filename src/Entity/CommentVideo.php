<?php

namespace App\Entity;

use App\Entity\Video;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentVideoRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
// use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 * formats="json",
 * collectionOperations={"get"={"method"="GET"}, "post"={"method"="POST"}}, 
 * itemOperations={"get"={"method"="GET"}}, 
 * normalizationContext={"groups"={"comment_video_read"}},
 * attributes={"order"={"createdAt": "ASC"}})
 * @ORM\Entity(repositoryClass=CommentVideoRepository::class)
 */
class CommentVideo
{
    use TimestampableEntity;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"comment_video_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"comment_video_read"})
     * @Assert\NotBlank
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity=Video::class, inversedBy="commentVideos")
     */
    private $video;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"comment_video_read"})
     * @Assert\NotBlank
     */
    private $author;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getVideo(): ?Video
    {
        return $this->video;
    }

    public function setVideo(?Video $video): self
    {
        $this->video = $video;

        return $this;
    }
    /**
     * @Groups({"comment_video_read"})
     * Returns createdAt.
     * @SerializedName("createdAt")
     */
    // createdAT provided by TimestampableEntity trait. 
    public function getCreatedAtTimestampable(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @Groups({"comment_video_read"})
     * Returns updatedAt.
     * @SerializedName("updatedAt")
     */
    // createdAT provided by TimestampableEntity trait. 
    public function getUpdatedAtTimestampable(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function __toString()
    {
        return  $this->author;
    }
}
