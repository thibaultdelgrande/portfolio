<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\VideoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => ['video:item']]),
        new GetCollection(normalizationContext: ['groups' => ['video:list']])
    ],
    order: ['project.releaseDate' => 'DESC'],
    paginationEnabled: false
)]
#[ApiFilter(SearchFilter::class, properties: [ 'project' => 'exact'])]
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['video:list', 'video:item'])]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'video', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['video:list', 'video:item'])]
    private ?Project $project = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(Project $project): static
    {
        $this->project = $project;

        return $this;
    }
}
