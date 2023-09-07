<?php

namespace App\Entity\Segment;

use App\Entity\Document\Document;
use App\Repository\SegmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SegmentRepository::class)]
#[ORM\Table(name: 'segments')]
class Segment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'segments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Document $document = null;

    #[ORM\Column(type: 'text')]
    private ?string $sourceText = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $targetText = null;

    #[ORM\Column(length: 3)]
    private ?string $sourceLanguage = null;

    #[ORM\Column(length: 3)]
    private ?string $targetLanguage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocument(): ?Document
    {
        return $this->document;
    }

    public function setDocument(?Document $document): self
    {
        $this->document = $document;

        return $this;
    }

    public function getSourceText(): ?string
    {
        return $this->sourceText;
    }

    public function setSourceText(string $sourceText): self
    {
        $this->sourceText = $sourceText;

        return $this;
    }

    public function getTargetText(): ?string
    {
        return $this->targetText;
    }

    public function setTargetText(?string $targetText): self
    {
        $this->targetText = $targetText;

        return $this;
    }

    public function getSourceLanguage(): ?string
    {
        return $this->sourceLanguage;
    }

    public function setSourceLanguage(string $sourceLanguage): self
    {
        $this->sourceLanguage = $sourceLanguage;

        return $this;
    }

    public function getTargetLanguage(): ?string
    {
        return $this->targetLanguage;
    }

    public function setTargetLanguage(string $targetLanguage): self
    {
        $this->targetLanguage = $targetLanguage;

        return $this;
    }
}
