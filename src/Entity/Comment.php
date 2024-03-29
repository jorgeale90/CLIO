<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */

class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_created;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="id", onDelete = "CASCADE")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="comments")
     */
    private $post;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $state;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $portada;

    /**
     * @ORM\OneToMany(targetEntity="CommentMark", mappedBy="comment", orphanRemoval=true)
     */
    private $commentMarks;

    public function __construct()
    {
        $this->state = false;
        $this->portada = false;
        $this->commentMarks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->date_created;
    }

    public function setDateCreated(?\DateTimeInterface $date_created): self
    {
        $this->date_created = $date_created;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getState(): ?bool
    {
        return $this->state;
    }

    public function setState(?bool $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getPortada(): ?bool
    {
        return $this->portada;
    }

    public function setPortada(?bool $portada): self
    {
        $this->portada = $portada;

        return $this;
    }

    /**
     * @return Collection|CommentMark[]
     */
    public function getCommentMarks(): Collection
    {
        return $this->commentMarks;
    }

    public function addCommentMark(CommentMark $commentMark): self
    {
        if (!$this->commentMarks->contains($commentMark)) {
            $this->commentMarks[] = $commentMark;
            $commentMark->setComment($this);
        }

        return $this;
    }

    public function removeCommentMark(CommentMark $commentMark): self
    {
        if ($this->commentMarks->removeElement($commentMark)) {
            // set the owning side to null (unless already changed)
            if ($commentMark->getComment() === $this) {
                $commentMark->setComment(null);
            }
        }

        return $this;
    }
}
