<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ContactRepository;
use App\Traits\YanTimestampableEntity;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\GeneratedValue;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ApiResource(
 * formats="json",
 * collectionOperations={"get"={"method"="GET"}, "post"={"method"="POST"}}, 
 * itemOperations={"get"={"method"="GET"}}, 
 * normalizationContext={"groups"={"contact_read"}}
 * )
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 * @UniqueEntity(fields="email", message="Cet email nous a déja contacté")
 */
class Contact
{
    use YanTimestampableEntity;
    /**
     * @ORM\Id
     * @GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     * @Groups({"contact_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"contact_read"})
     * @Assert\NotBlank
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"contact_read"})
     * @Assert\NotBlank
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"contact_read"})
     * @Assert\NotBlank
     */
    private $message;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
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
    public function __toString()
    {
        return  $this->email;
    }
}
