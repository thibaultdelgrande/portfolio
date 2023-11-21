<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => ['album:item']]),
        new GetCollection(normalizationContext: ['groups' => ['album:list']])
    ],
    order: ['project.releaseDate' => 'DESC'],
    paginationEnabled: false
)]
#[ApiFilter(SearchFilter::class, properties: [ 'project' => 'exact'])]
class Album
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['album:list', 'album:item'])]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'album', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['album:list', 'album:item'])]
    private ?Project $project = null;

    #[ORM\Column]
    #[Groups(['album:list', 'album:item'])]
    private ?bool $single = null;

    #[ORM\OneToMany(mappedBy: 'album', targetEntity: AlbumSong::class, orphanRemoval: true, cascade:["persist"])]
    #[Groups(['album:list', 'album:item'])]
    private Collection $songs;

    public function __construct()
    {
        $this->songs = new ArrayCollection();
    }

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

    public function isSingle(): ?bool
    {
        return $this->single;
    }

    public function setSingle(bool $single): static
    {
        $this->single = $single;

        return $this;
    }

    /**
     * @return Collection<int, AlbumSong>
     */
    public function getSongs(): Collection
    {
        return $this->songs;
    }

    public function addSong(AlbumSong $song): static
    {
        if (!$this->songs->contains($song)) {
            $this->songs->add($song);
            $song->setAlbum($this);
        }

        return $this;
    }

    public function removeSong(AlbumSong $song): static
    {
        if ($this->songs->removeElement($song)) {
            // set the owning side to null (unless already changed)
            if ($song->getAlbum() === $this) {
                $song->setAlbum(null);
            }
        }

        return $this;
    }
}
