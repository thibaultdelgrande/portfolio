<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\SongRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SongRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => ['song:item']]),
        new GetCollection(normalizationContext: ['groups' => ['song:list']])
    ],
    order: ['title' => 'ASC'],
    paginationEnabled: false
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'title' => 'partial'])]
class Song
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['song:list', 'song:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['song:list', 'song:item'])]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'song', targetEntity: AlbumSong::class, orphanRemoval: true)]
    #[Groups(['song:list', 'song:item'])]
    private Collection $albums;

    public function __construct()
    {
        $this->albums = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title ?? '';
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

    /**
     * @return Collection<int, AlbumSong>
     */
    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(AlbumSong $album): static
    {
        if (!$this->albums->contains($album)) {
            $this->albums->add($album);
            $album->setSong($this);
        }

        return $this;
    }

    public function removeAlbum(AlbumSong $album): static
    {
        if ($this->albums->removeElement($album)) {
            // set the owning side to null (unless already changed)
            if ($album->getSong() === $this) {
                $album->setSong(null);
            }
        }

        return $this;
    }
}
