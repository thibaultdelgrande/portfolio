<?php

namespace App\Entity;


use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\ProjectLinkRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectLinkRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => ['projectLink:item']]),
        new GetCollection(normalizationContext: ['groups' => ['projectLink:list']])
    ],
    order: ['url' => 'ASC'],
    paginationEnabled: false
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'url' => 'partial'])]
class ProjectLink
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['projectLink:list', 'projectLink:item'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'projectLinks')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['projectLink:list', 'projectLink:item'])]
    private ?Project $project = null;

    #[ORM\ManyToOne(inversedBy: 'projectLinks')]
    #[Groups(['projectLink:list', 'projectLink:item'])]
    private ?Platform $platform = null;

    #[ORM\Column(length: 255)]
    #[Groups(['projectLink:list', 'projectLink:item'])]
    private ?string $url = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->getUrl();
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function getPlatform(): ?Platform
    {
        return $this->platform;
    }

    public function setPlatform(?Platform $platform): static
    {
        $this->platform = $platform;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }
}
