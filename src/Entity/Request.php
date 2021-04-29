<?php

namespace App\Entity;

use App\Repository\RequestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RequestRepository::class)
 */
class Request
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
    private $requestURL;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $requestMethod;

    /**
     * @ORM\Column(type="datetime")
     */
    private $requestedAt;

    public function __construct($requestURL = null, $requestMethod = null, $requestedAt = null)
    {
        $this->requestURL = $requestURL;
        $this->requestMethod = $requestMethod;
        $this->requestedAt = $requestedAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRequestURL(): ?string
    {
        return $this->requestURL;
    }

    public function setRequestURL(string $requestURL): self
    {
        $this->requestURL = $requestURL;

        return $this;
    }

    public function getRequestMethod(): ?string
    {
        return $this->requestMethod;
    }

    public function setRequestMethod(string $requestMethod): self
    {
        $this->requestMethod = $requestMethod;

        return $this;
    }

    public function getRequestedAt(): ?\DateTimeInterface
    {
        return $this->requestedAt;
    }

    public function setRequestedAt(\DateTimeInterface $requestedAt): self
    {
        $this->requestedAt = $requestedAt;

        return $this;
    }
}
