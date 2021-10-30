<?php

namespace App\Entity;

use App\Repository\CommentMarkRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CommentMarkRepository::class)
 * @ORM\Table(name="comments_marks")
 */

class CommentMark
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(
     *     type="integer"
     * )
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="1",
     *     max="5",
     * )
     */
    private $mark;

    /**
     * @ORM\ManyToOne(targetEntity="Comment", inversedBy="commentMarks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="commentMarks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMark(): ?int
    {
        return $this->mark;
    }

    public function setMark(int $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    public function getComment(): ?Comment
    {
        return $this->comment;
    }

    public function setComment(?Comment $comment): self
    {
        $this->comment = $comment;

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
}
