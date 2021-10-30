<?php

namespace App\Entity;

use App\Repository\PostMarkRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PostMarkRepository::class)
 * @ORM\Table(name="posts_marks")
 */

class PostMark
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Mark.
     *
     * @var string
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
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="postMarks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="postMarks")
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

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

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
