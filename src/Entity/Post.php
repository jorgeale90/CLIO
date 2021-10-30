<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 * @Audit\Auditable()
 * @Audit\Security(view={"ROLE_ADMIN"})
 * @Vich\Uploadable
 */

class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="No debe estar vacío")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="No debe estar vacío")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_created;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $view_count;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="id", onDelete = "CASCADE")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="id", onDelete = "CASCADE")
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="post", orphanRemoval=true)
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private $comments;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subheading;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $tags = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $sharing_icons;

    /**
     * @ORM\Column(type="boolean")
     */
    private $allow_comments;

    /**
     * @ORM\Column(type="boolean")
     */
    private $fijar_post;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="post_image", fileNameProperty="imageName", size="imageSize")
     *
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string|null
     */
    private $imageName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var int|null
     */
    private $imageSize;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="PostMark", mappedBy="post", orphanRemoval=true)
     */
    private $postMarks;

    public function __toString() 
    {
        return $this->getTitle();
    }

    public function __construct()
    {
        $this->fijar_post = false;
        $this->comments = new ArrayCollection();
        $this->postMarks = new ArrayCollection();
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function getId(): ?int
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getViewCount(): ?int
    {
        return $this->view_count;
    }

    public function setViewCount(?int $view_count): self
    {
        $this->view_count = $view_count;

        return $this;
    }

    public function setCover(?string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getSubheading(): ?string
    {
        return $this->subheading;
    }

    public function setSubheading(?string $subheading): self
    {
        $this->subheading = $subheading;

        return $this;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(?array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getSharingIcons(): ?bool
    {
        return $this->sharing_icons;
    }

    public function setSharingIcons(bool $sharing_icons): self
    {
        $this->sharing_icons = $sharing_icons;

        return $this;
    }

    public function getAllowComments(): ?bool
    {
        return $this->allow_comments;
    }

    public function setAllowComments(bool $allow_comments): self
    {
        $this->allow_comments = $allow_comments;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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
            $comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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
            $postMark->setPost($this);
        }

        return $this;
    }

    public function removePostMark(PostMark $postMark): self
    {
        if ($this->postMarks->removeElement($postMark)) {
            // set the owning side to null (unless already changed)
            if ($postMark->getPost() === $this) {
                $postMark->setPost(null);
            }
        }

        return $this;
    }

    public function getFijarPost(): ?bool
    {
        return $this->fijar_post;
    }

    public function setFijarPost(bool $fijar_post): self
    {
        $this->fijar_post = $fijar_post;

        return $this;
    }
}
