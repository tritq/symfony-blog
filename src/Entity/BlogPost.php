<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="blog_posts")
 * @ORM\Entity(repositoryClass="App\Repository\BlogPostRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class BlogPost
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=2000, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Author", inversedBy="blogPosts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @ORM\Column(type="datetimetz", name="date_of_creation")
     */
    private $dateOfCreation;

    /**
     * @ORM\Column(type="datetimetz", name="date_of_modification")
     */
    private $dateOfModification;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getDateOfCreation(): ?\DateTimeInterface
    {
        return $this->dateOfCreation;
    }

    public function setDateOfCreation(\DateTimeInterface $dateOfCreation): self
    {
        $this->dateOfCreation = $dateOfCreation;

        return $this;
    }

    public function getDateOfModification(): ?\DateTimeInterface
    {
        return $this->dateOfModification;
    }

    public function setDateOfModification(\DateTimeInterface $dateOfModification): self
    {
        $this->dateOfModification = $dateOfModification;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $current_time = new \DateTime();

        $this->setActive(false);

        if (!$this->getDateOfCreation()) {
            $this->setDateOfCreation($current_time);
        }

        if (!$this->getDateOfModification()) {
            $this->setDateOfModification($current_time);
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $current_time = new \DateTime();

        if (!$this->getDateOfModification()) {
            $this->setDateOfModification($current_time);
        }
    }
}
