<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\PBookRepository")
 */
class PBook
{
    public const STATUS_INSIDE = 'inside';
    public const STATUS_OUTSIDE = 'outside';
    public const STATUS_RESERVED = 'reserved';
    public const STATUS_NOT_AVAILABLE = 'no_available';
    public const STATUS = [ 'inside', 'outside', 'reserved', 'not_available' ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Book", inversedBy="pBook")
     * @ORM\JoinColumn(nullable=false)
     */
    private $book;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     *
     * @var array
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="pBook")
     */
    private $bookings;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Library", inversedBy="pBooks")
     */
    private $library;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->status = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Book|null
     */
    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    public function getStatus(): array
    {
        return is_array($this->status) ? $this->status : explode(',', $this->status);
    }

    public function setStatus(array $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function addStatus( string $status): self
    {
        if (!$this->bookings->contains($status) && count($this->status) < 2) {
            $this->status[] = $status;
        }

        return $this;
    }

    public function removeStatus(string $status): self
    {
        if ($this->status->contains($status)) {
            $this->status->removeElement($status);
        }

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setPBook($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getPBook() === $this) {
                $booking->setPBook(null);
            }
        }

        return $this;
    }

    public function getLibrary(): ?Library
    {
        return $this->library;
    }

    public function setLibrary(?Library $library): self
    {
        $this->library = $library;

        return $this;
    }
}
