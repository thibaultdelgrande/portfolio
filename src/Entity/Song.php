<?php

namespace App\Entity;

use App\Repository\SongRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SongRepository::class)]
class Song
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'song', targetEntity: AlbumSong::class, orphanRemoval: true)]
    private Collection $albums;

    public function __construct()
    {
        $this->albums = new ArrayCollection();
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
