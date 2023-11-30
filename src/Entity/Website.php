<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\WebsiteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\Project;

#[ORM\Entity(repositoryClass: WebsiteRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => ['website:item']]),
        new GetCollection(normalizationContext: ['groups' => ['website:list']])
    ],
    order: ['project.releaseDate' => 'DESC'],
    paginationEnabled: false
)]
#[ApiFilter(SearchFilter::class, properties: [ 'project' => 'exact'])]
class Website
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['website:list', 'website:item'])]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'website', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['website:list', 'website:item'])]
    private ?project $project = null;

    #[ORM\Column(length: 255)]
    #[Groups(['website:list', 'website:item'])]
    private ?string $url = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?project
    {
        return $this->project;
    }

    public function setProject(project $project): static
    {
        $this->project = $project;

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
