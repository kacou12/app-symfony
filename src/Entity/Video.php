<?php

namespace App\Entity;

use App\Entity\Categorie;
use App\Entity\CommentVideo;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\VideoRepository;
use Gedmo\Mapping\Annotation as Gedmo;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\HttpFoundation\File\File;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ApiResource(
 * formats="json",
 * collectionOperations={"get"={"method"="GET"}}, 
 * itemOperations={"get"={"method"="GET"}}, 
 * attributes={"order"={"id": "desc"}},
 * normalizationContext={"groups"={"video_read"}},
 *  attributes={"order"={"id": "desc"}}
 * )
 * @ApiFilter(SearchFilter::class, properties= {"title": "partial"}))
 * 
 * @ORM\Entity(repositoryClass=VideoRepository::class)
 * @Vich\Uploadable
 */
class Video
{
    use TimestampableEntity;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"video_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"video_read"})
     * @Assert\NotBlank
     */
    private $url;

    /**
     * @Vich\UploadableField(mapping="Video", fileNameProperty="url")
     * @var File
     */
    private $videoFile;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"video_read"})
     * @Assert\NotBlank
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"video_read"})
     * @Assert\NotBlank
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="videos")
     * @Groups({"video_read"})
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=CommentVideo::class, mappedBy="video")
     * @ApiSubresource()
     */
    private $commentVideos;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"video_read"})
     */
    private $author;

    public function setVideoFile(File $video = null)
    {
        $this->videoFile = $video;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($video) {
            // $this->url = "potata";
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getVideoFile()
    {
        return $this->videoFile;
    }

    public function __construct()
    {
        $this->commentVideos = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
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

    public function setContent(?string $content): self
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
     * @return Collection|CommentVideo[]
     */
    public function getCommentVideos(): Collection
    {
        return $this->commentVideos;
    }

    public function addCommentVideo(CommentVideo $commentVideo): self
    {
        if (!$this->commentVideos->contains($commentVideo)) {
            $this->commentVideos[] = $commentVideo;
            $commentVideo->setVideo($this);
        }

        return $this;
    }

    public function removeCommentVideo(CommentVideo $commentVideo): self
    {
        if ($this->commentVideos->removeElement($commentVideo)) {
            // set the owning side to null (unless already changed)
            if ($commentVideo->getVideo() === $this) {
                $commentVideo->setVideo(null);
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
    /**
     * @Groups({"video_read"})
     * Returns createdAt.
     * @SerializedName("createdAt")
     */
    // createdAT provided by TimestampableEntity trait. 
    public function getCreatedAtTimestampable(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @Groups({"video_read"})
     * Returns updatedAt.
     * @SerializedName("updatedAt")
     */
    // createdAT provided by TimestampableEntity trait. 
    public function getUpdatedAtTimestampable(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }
}
