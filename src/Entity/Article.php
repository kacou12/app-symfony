<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArticleRepository;
use Gedmo\Mapping\Annotation as Gedmo;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\File\File;
// use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Symfony\Component\Serializer\Annotation\SerializedName;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ApiResource(
 * formats="json",
 * attributes={"order"={"id": "desc"}},
 * normalizationContext={"groups"={"article_read"}}
 * )
 * @ApiFilter(SearchFilter::class, properties= {"title": "partial"}))
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @Vich\Uploadable
 */
class Article
{
    use TimestampableEntity;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"article_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"article_read"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"article_read"})
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="articles")
     * @Groups({"article_read"})
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=CommentArticle::class, mappedBy="article")
     * @ApiSubresource()
     */
    private $commentArticles;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"article_read"})
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"article_read"})
     */
    private $image;


    /**
     * @Vich\UploadableField(mapping="Article", fileNameProperty="image")
     * @var File
     */
    private $imageFile;



    public function __construct()
    {
        $this->commentArticles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
    public function __toString()
    {
        return  $this->title;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|CommentArticle[]
     */
    public function getCommentArticles(): Collection
    {
        return $this->commentArticles;
    }

    public function addCommentArticle(CommentArticle $commentArticle): self
    {
        if (!$this->commentArticles->contains($commentArticle)) {
            $this->commentArticles[] = $commentArticle;
            $commentArticle->setArticle($this);
        }

        return $this;
    }

    public function removeCommentArticle(CommentArticle $commentArticle): self
    {
        if ($this->commentArticles->removeElement($commentArticle)) {
            // set the owning side to null (unless already changed)
            if ($commentArticle->getArticle() === $this) {
                $commentArticle->setArticle(null);
            }
        }

        return $this;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
    /**
     * @Groups({"article_read"})
     * Returns createdAt.
     * @SerializedName("createdAt")
     */
    // createdAT provided by TimestampableEntity trait. 
    public function getCreatedAtTimestampable(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @Groups({"article_read"})
     * Returns updatedAt.
     * @SerializedName("updatedAt")
     */
    // createdAT provided by TimestampableEntity trait. 
    public function getUpdatedAtTimestampable(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }
}
