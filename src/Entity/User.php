<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation\Auditable;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="Ya existe este Email.")
 * @Auditable()
 * @Vich\Uploadable
 */

class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $lastname;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Notification", mappedBy="user", cascade={"persist", "remove"})
     */
    private $notifications;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isadmin;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Especialista", mappedBy="credentials", cascade={"persist", "remove"})
     */
    private $especialista;

    /**
     * It only stores the name of the image associated with the product.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="user_images", fileNameProperty="image")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="created_at", nullable=true)
     */
    private $createdAt = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="user", orphanRemoval=true)
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="CommentMark", mappedBy="user", orphanRemoval=true)
     */
    private $commentMarks;

    /**
     * @ORM\OneToMany(targetEntity="PostMark", mappedBy="user", orphanRemoval=true)
     */
    private $postMarks;

    public function __construct()
    {
        $this->notifications = new ArrayCollection();
        $this->isadmin = false;
        $this->status = false;
        $this->posts = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->commentMarks = new ArrayCollection();
        $this->postMarks = new ArrayCollection();
    }

    public function getNombreCompleto() {

        return $this->getFirstname() . " " . $this->getLastname();

    }

    public function __toString() {

        return $this->getNombreCompleto();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Notification[]
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setUser($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->contains($notification)) {
            $this->notifications->removeElement($notification);
            // set the owning side to null (unless already changed)
            if ($notification->getUser() === $this) {
                $notification->setUser(null);
            }
        }

        return $this;
    }

    public function getIsadmin(): ?bool
    {
        return $this->isadmin;
    }

    public function setIsadmin(bool $isadmin): self
    {
        $this->isadmin = $isadmin;

        return $this;
    }

    public function getEspecialista(): ?Especialista
    {
        return $this->especialista;
    }

    public function setEspecialista(?Especialista $especialista): self
    {
        $this->especialista = $especialista;

        // set (or unset) the owning side of the relation if necessary
        $newCredentials = null === $especialista ? null : $this;
        if ($especialista->getCredentials() !== $newCredentials) {
            $especialista->setCredentials($newCredentials);
        }

        return $this;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * String representation of object
     * @link https://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
            $this->image,
        ));
    }

    /**
     * Constructs the object
     * @link https://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            $this->image,
            ) = unserialize($serialized, array('allowed_classes' => false));
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

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
            $commentMark->setUser($this);
        }

        return $this;
    }

    public function removeCommentMark(CommentMark $commentMark): self
    {
        if ($this->commentMarks->contains($commentMark)) {
            $this->commentMarks->removeElement($commentMark);
            // set the owning side to null (unless already changed)
            if ($commentMark->getUser() === $this) {
                $commentMark->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PostMark[]
     */
    public function getPostMarks(): Collection
    {
        return $this->postMarks;
    }

    public function addPostMark(PostMark $postMark): self
    {
        if (!$this->postMarks->contains($postMark)) {
            $this->postMarks[] = $postMark;
            $postMark->setUser($this);
        }

        return $this;
    }

    public function removePostMark(PostMark $postMark): self
    {
        if ($this->postMarks->contains($postMark)) {
            $this->postMarks->removeElement($postMark);
            // set the owning side to null (unless already changed)
            if ($postMark->getUser() === $this) {
                $postMark->setUser(null);
            }
        }

        return $this;
    }
}