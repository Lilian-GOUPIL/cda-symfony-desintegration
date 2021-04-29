<?php

namespace App\Entity;

use App\Repository\ProposalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ProposalRepository::class)
 */
class Proposal
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\File(mimeTypes={"image/jpeg", "image/png", "image/gif"})
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastUpdatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="proposals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $proposedBy;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="votes")
     */
    private $votedBy;

    public function __construct()
    {
        $this->votedBy = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getLastUpdatedAt(): ?\DateTimeInterface
    {
        return $this->lastUpdatedAt;
    }

    public function setLastUpdatedAt(\DateTimeInterface $lastUpdatedAt): self
    {
        $this->lastUpdatedAt = $lastUpdatedAt;

        return $this;
    }

    public function getProposedBy(): ?User
    {
        return $this->proposedBy;
    }

    public function setProposedBy(?User $proposedBy): self
    {
        $this->proposedBy = $proposedBy;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getVotedBy(): Collection
    {
        return $this->votedBy;
    }

    public function addVotedBy(User $votedBy): self
    {
        if (!$this->votedBy->contains($votedBy)) {
            $this->votedBy[] = $votedBy;
        }

        return $this;
    }

    public function removeVotedBy(User $votedBy): self
    {
        $this->votedBy->removeElement($votedBy);

        return $this;
    }

    public function __toString()
    {
        return ('Proposal -> [id : ' . $this->id .', title : ' . $this->title .', description : ' . $this->description . ', proposedBy : ' . $this->getProposedBy() . ']');
    }
}
