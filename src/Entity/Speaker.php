<?php

namespace App\Entity;

use App\Repository\SpeakerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SpeakerRepository::class)
 */
class Speaker
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $bio;

    /**
     * @ORM\OneToMany(targetEntity=Conference::class, mappedBy="speaker")
     */
    private $conferences;

    public function __construct()
    {
        $this->conferences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * @return Collection|conference[]
     */
    public function getConferences(): Collection
    {
        return $this->conferences;
    }

    public function addConference(conference $conference): self
    {
        if (!$this->conferences->contains($conference)) {
            $this->conferences[] = $conference;
            $conference->setSpeaker($this);
        }

        return $this;
    }

    public function removeConference(conference $conference): self
    {
        if ($this->conferences->removeElement($conference)) {
            // set the owning side to null (unless already changed)
            if ($conference->getSpeaker() === $this) {
                $conference->setSpeaker(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->surname.' '.$this->name;
    }
}
