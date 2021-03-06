<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuthorRepository")
 */
class Author
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(name="middle_name", type="string", length=255)
     */
    private $middleName;

    /**
     * @var \Doctrine\Common\Collections\Collection|Book[]
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Book", inversedBy="authors", cascade={"persist", "remove"})
     */
    private $books;

    /**
     * Author constructor.
     */
    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $first_name): self
    {
        $this->firstName = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function setMiddleName(string $middleName): self
    {
        $this->middleName = $middleName;

        return $this;
    }

    /**
     * @return Collection|Book[]
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->addAuthor($this);
        }

        return $this;
    }


    /**
     * @param Book $book
     * @return Author
     */
    public function removeBook(Book $book): self
    {
        if ($this->books->contains($book)) {
            $this->books->removeElement($book);
            $book->removeAuthor($this);
        }

        return $this;
    }

    /**
     * get surname and initials
     *
     * @return string
     */
    public function getShortName(): ?string
    {
        return ucwords($this->lastName . ' ' . substr($this->firstName, 0, 1) . ' ' . substr($this->middleName, 0, 1));
    }

    /**
     * @return string|null
     */
    public function getFullName(): ?string
    {
        return ucwords($this->lastName . ' ' . $this->firstName . ' ' . $this->middleName);
    }
}
