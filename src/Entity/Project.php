<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[Vich\Uploadable]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => ['project:item']]),
        new GetCollection(normalizationContext: ['groups' => ['project:list']])
    ],
    order: ['releaseDate' => 'DESC'],
    paginationEnabled: false
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'title' => 'partial', 'description' => 'partial'])]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['project:list', 'project:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['project:list', 'project:item'])]
    private ?string $title = null;

    #[ORM\Column]
    #[Groups(['project:list', 'project:item'])]
    private ?\DateTimeImmutable $releaseDate = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['project:list', 'project:item'])]
    private ?string $description = null;

    #[Vich\UploadableField(mapping: 'projects_logos', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $logo = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['project:list', 'project:item'])]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['project:list', 'project:item'])]
    private ?int $imageSize = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['project:list', 'project:item'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: ProjectLink::class, orphanRemoval: true, cascade:["persist"])]
    #[Groups(['project:list', 'project:item'])]
    private Collection $projectLinks;

    #[ORM\OneToOne(mappedBy: 'project', cascade: ['persist', 'remove'])]
    #[Groups(['project:list', 'project:item'])]
    private ?Game $game = null;

    #[ORM\OneToOne(mappedBy: 'project', cascade: ['persist', 'remove'])]
    #[Groups(['project:list', 'project:item'])]
    private ?Album $album = null;

    #[ORM\OneToOne(mappedBy: 'project', cascade: ['persist', 'remove'])]
    private ?Website $website = null;

    public function __construct()
    {
        $this->projectLinks = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getTitle();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeImmutable
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeImmutable $releaseDate): static
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function setLogo(?File $logo = null): void
    {
        $this->logo = $logo;

        if (null !== $logo) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getLogo(): ?File
    {
        return $this->logo;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @return Collection<int, ProjectLink>
     */
    public function getProjectLinks(): Collection
    {
        return $this->projectLinks;
    }

    public function addProjectLink(ProjectLink $projectLink): static
    {
        if (!$this->projectLinks->contains($projectLink)) {
            $this->projectLinks->add($projectLink);
            $projectLink->setProject($this);
        }

        return $this;
    }

    public function removeProjectLink(ProjectLink $projectLink): static
    {
        if ($this->projectLinks->removeElement($projectLink)) {
            // set the owning side to null (unless already changed)
            if ($projectLink->getProject() === $this) {
                $projectLink->setProject(null);
            }
        }

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(Game $game): static
    {
        // set the owning side of the relation if necessary
        if ($game->getProject() !== $this) {
            $game->setProject($this);
        }

        $this->game = $game;

        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(Album $album): static
    {
        // set the owning side of the relation if necessary
        if ($album->getProject() !== $this) {
            $album->setProject($this);
        }

        $this->album = $album;

        return $this;
    }

    public function getWebsite(): ?Website
    {
        return $this->website;
    }

    public function setWebsite(Website $website): static
    {
        // set the owning side of the relation if necessary
        if ($website->getProject() !== $this) {
            $website->setProject($this);
        }

        $this->website = $website;

        return $this;
    }
}