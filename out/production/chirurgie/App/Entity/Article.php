<?php

namespace App\Entity;

use App\Entity\Comment;
use App\Entity\Image;
use App\Repository\ArticleRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Stmt\PropertyProperty;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class Article {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank(message="Vous devez renseigner la référence!")
     * @Assert\Length(min=2, max=10, minMessage="La référence doit contenir plus de 2 caractères !", maxMessage="La référence ne pas contenir plus de 10 caractères !")
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Vous devez renseigner la désignation!")
     * @Assert\Length(min=2, max=100, minMessage="La désignation doit contenir plus de 2 caractères !", maxMessage="La désignation ne doit pas contenir plus de 100 caractères !")
     */
    private $designation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string|null
     */
    private $coverImage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @Vich\UploadableField(mapping="article_images", fileNameProperty="coverImage")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2)
     * @Assert\NotBlank(message="Vous devez renseigner le prix!")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=SousFamille::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sousFamille;

    /**
     * @ORM\ManyToMany(targetEntity=Article::class, inversedBy="articles")
     */
    private $relatedTo;

    /**
     * @ORM\ManyToMany(targetEntity=Article::class, mappedBy="relatedTo")
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity=OrderDetail::class, mappedBy="article")
     */
    private $orderDetails;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="article")
     */
    private $comments;

    /**
     *  @var ArrayCollection
     *  @ORM\OneToMany(targetEntity=Image::class, mappedBy="article", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $images;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Variant::class, mappedBy="article", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $variants;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     */
    private $priceProfessional;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     */
    private $priceDealer;

//    /**
//     * @ORM\OneToMany(targetEntity=ArticleSize::class, mappedBy="article")
//     */
//    private $sizes;

    public function __construct() {
        $this->relatedTo = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->orderDetails = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->images = new ArrayCollection();
//        $this->sizes = new ArrayCollection();
        $this->variants = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getReference(): ?string {
        return $this->reference;
    }

    public function setReference(string $reference): self {
        $this->reference = $reference;
        return $this;
    }

    public function getDesignation(): ?string {
        return $this->designation;
    }

    public function setDesignation(string $designation): self {
        $this->designation = $designation;
        return $this;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(string $description): self {
        $this->description = $description;
        return $this;
    }

    public function getCoverImage(): ?string {
        return $this->coverImage;
    }

    public function setCoverImage(?string $coverImage): self {
//    public function setCoverImage(?string $coverImage): Article {
        $this->coverImage = $coverImage;
        return $this;
    }

    public function getPrice(): ?string {
        return $this->price;
    }

    public function setPrice(string $price): self {
        $this->price = $price;
        return $this;
    }

    public function getSousFamille(): ?\App\Entity\SousFamille {
        return $this->sousFamille;
    }

    public function setSousFamille(?\App\Entity\SousFamille $sousFamille): self {
        $this->sousFamille = $sousFamille;
        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getRelatedTo(): Collection {
        return $this->relatedTo;
    }

    public function addRelatedTo(self $relatedTo): self {
        if (!$this->relatedTo->contains($relatedTo)) {
            $this->relatedTo[] = $relatedTo;
        }
        return $this;
    }

    public function removeRelatedTo(self $relatedTo): self {
        if ($this->relatedTo->contains($relatedTo)) {
            $this->relatedTo->removeElement($relatedTo);
        }
        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getArticles(): Collection {
        return $this->articles;
    }

    public function addArticle(self $article): self {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->addRelatedTo($this);
        }
        return $this;
    }

    public function removeArticle(self $article): self {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            $article->removeRelatedTo($this);
        }
        return $this;
    }

    /**
     * @return Collection|\App\Entity\OrderDetail[]
     */
    public function getOrderDetails(): Collection {
        return $this->orderDetails;
    }

    public function addOrderDetail(\App\Entity\OrderDetail $orderDetail): self {
        if (!$this->orderDetails->contains($orderDetail)) {
            $this->orderDetails[] = $orderDetail;
            $orderDetail->setArticle($this);
        }
        return $this;
    }

    public function removeOrderDetail(\App\Entity\OrderDetail $orderDetail): self {
        if ($this->orderDetails->contains($orderDetail)) {
            $this->orderDetails->removeElement($orderDetail);
            // set the owning side to null (unless already changed)
            if ($orderDetail->getArticle() === $this) {
                $orderDetail->setArticle(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection {
        return $this->comments;
    }

    public function addComment(Comment $comment): self {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setArticle($this);
        }
        return $this;
    }

    public function removeComment(Comment $comment): self {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getArticle() === $this) {
                $comment->setArticle(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection {
        return $this->images;
    }

    public function addImage(Image $image): self {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setArticle($this);
        }
        return $this;
    }

    public function removeImage(Image $image): self {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getArticle() === $this) {
                $image->setArticle(null);
            }
        }
        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * @return void
     */
    public function initializeUpdatedAt() {
        $this->updatedAt = new \DateTime('now');
    }

    public function getUpdatedAt(): ?\DateTimeInterface {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function setImageFile(File $image = null) {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile() {
        return $this->imageFile;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * 
     * @return void
     */
    public function initializeSlug() {
        if (empty($this->slug)) {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->designation);
        }
    }

    function getSlug() {
        return $this->slug;
    }

    function setSlug($slug): void {
        $this->slug = $slug;
    }

    public function __toString() {
        return $this->designation;
    }

//    /**
//     * @return Collection|ArticleSize[]
//     */
//    public function getSizes(): Collection
//    {
//        return $this->sizes;
//    }
//
//    public function addSize(ArticleSize $size): self
//    {
//        if (!$this->sizes->contains($size)) {
//            $this->sizes[] = $size;
//            $size->setArticle($this);
//        }
//
//        return $this;
//    }
//
//    public function removeSize(ArticleSize $size): self
//    {
//        if ($this->sizes->contains($size)) {
//            $this->sizes->removeElement($size);
//            // set the owning side to null (unless already changed)
//            if ($size->getArticle() === $this) {
//                $size->setArticle(null);
//            }
//        }
//
//        return $this;
//    }

    /**
     * @return Collection|Variant[]
     */
    public function getVariants(): Collection {
        return $this->variants;
    }

    public function addVariant(Variant $variant): self {
        if (!$this->variants->contains($variant)) {
            $this->variants[] = $variant;
            $variant->setArticle($this);
        }

        return $this;
    }

    public function removeVariant(Variant $variant): self {
        if ($this->variants->contains($variant)) {
            $this->variants->removeElement($variant);
            // set the owning side to null (unless already changed)
            if ($variant->getArticle() === $this) {
                $variant->setArticle(null);
            }
        }

        return $this;
    }

    public function getPriceProfessional(): ?string
    {
        return $this->priceProfessional;
    }

    public function setPriceProfessional(?string $priceProfessional): self
    {
        $this->priceProfessional = $priceProfessional;

        return $this;
    }

    public function getPriceDealer(): ?string
    {
        return $this->priceDealer;
    }

    public function setPriceDealer(?string $priceDealer): self
    {
        $this->priceDealer = $priceDealer;

        return $this;
    }

}
