<?php

namespace App\Entity;

use App\Repository\ExceptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExceptionRepository::class)
 */
class Exception
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\Column(type="datetime")
     */
    private $occuredAt;

    public function __construct($requestURL = null, $requestMethod = null, $code = null, $message = null, $trace = null, $occuredAt = null)
    {
        $this->requestURL = $requestURL;
        $this->requestMethod = $requestMethod;
        $this->code = $code;
        $this->message = $message;
        $this->trace = $trace;
        $this->occuredAt = $occuredAt;
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

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

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

    public function getOccuredAt(): ?\DateTimeInterface
    {
        return $this->occuredAt;
    }

    public function setOccuredAt(\DateTimeInterface $occuredAt): self
    {
        $this->occuredAt = $occuredAt;

        return $this;
    }
}
