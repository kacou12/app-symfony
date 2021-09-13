<?php

namespace App\Entity;

use App\Entity\Article;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentArticleRepository;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 * formats="json",
 * collectionOperations={"get"={"method"="GET"}, "post"={"method"="POST"}}, 
 * itemOperations={"get"={"method"="GET"}}, 
 * attributes={"order"={"id": "desc"}},
 * normalizationContext={"groups"={"comment_article_read"}}
 * )
 * @ORM\Entity(repositoryClass=CommentArticleRepository::class)
 */
class CommentArticle
{
    use TimestampableEntity;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"comment_article_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"comment_article_read"})
     * @Assert\NotBlank
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="commentArticles")
     * @Groups({"comment_article_read"})
     */
    private $article;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"comment_article_read"})
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

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }
    /**
     * @Groups({"comment_article_read"})
     * Returns createdAt.
     * @SerializedName("createdAt")
     */
    // createdAT provided by TimestampableEntity trait. 
    public function getCreatedAtTimestampable(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @Groups({"comment_article_read"})
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
