<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\PlatformRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: PlatformRepository::class)]
#[Vich\Uploadable]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => ['platform:item']]),
        new GetCollection(normalizationContext: ['groups' => ['platform:list']])
    ],
    order: ['name' => 'ASC'],
    paginationEnabled: false
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'name' => 'partial', 'color' => 'exact', 'link' => 'partial'])]
class Platform
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['platform:list', 'platform:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['platform:list', 'platform:item'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['platform:list', 'platform:item'])]
    private ?string $color = null;

    #[Vich\UploadableField(mapping: 'logos', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $logo = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['platform:list', 'platform:item'])]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['platform:list', 'platform:item'])]
    private ?int $imageSize = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['platform:list','platform:item'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $link = null;

    #[ORM\OneToMany(mappedBy: 'platform', targetEntity: ProjectLink::class)]
    private Collection $projectLinks;

    public function __construct()
    {
        $this->projectLinks = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

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

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;

        return $this;
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
            $projectLink->setPlatform($this);
        }

        return $this;
    }

    public function removeProjectLink(ProjectLink $projectLink): static
    {
        if ($this->projectLinks->removeElement($projectLink)) {
            // set the owning side to null (unless already changed)
            if ($projectLink->getPlatform() === $this) {
                $projectLink->setPlatform(null);
            }
        }

        return $this;
    }
}
