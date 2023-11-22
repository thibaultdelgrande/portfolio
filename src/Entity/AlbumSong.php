<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\AlbumSongRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlbumSongRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => ['album_song:item']]),
        new GetCollection(normalizationContext: ['groups' => ['album_song:list']])
    ],
    order: ['id' => 'ASC'],
    paginationEnabled: false
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'song' => 'exact', 'album' => 'exact'])]
class AlbumSong
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['album_song:list', 'album_song:item'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'albums')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['album_song:item', 'album_song:list'])]
    private ?Song $song = null;

    #[ORM\ManyToOne(inversedBy: 'songs')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['album_song:item', 'album_song:list'])]
    private ?Album $album = null;

    #[ORM\Column]
    #[Groups(['album_song:item', 'album_song:list'])]
    private ?int $duration = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['album_song:item', 'album_song:list'])]
    private ?string $version = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSong(): ?Song
    {
        return $this->song;
    }

    public function setSong(?Song $song): static
    {
        $this->song = $song;

        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): static
    {
        $this->album = $album;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): static
    {
        $this->version = $version;

        return $this;
    }
}
