<?php

namespace App\Entity;

use App\Entity\Image;
use App\Entity\Color;
use App\Entity\Size;
use App\Repository\VariantRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=VariantRepository::class)
 */
class Variant {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $reference;

    /**
     * @ORM\ManyToOne(targetEntity=Size::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $size;

    /**
     * @ORM\ManyToOne(targetEntity=Color::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $color;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $discounted;
//
//    /**
//     * @ORM\Column(type="boolean", nullable=true)
//     */
//    private $inStock;

    /**
     * @ORM\Column(type="decimal", precision=3, scale=2, nullable=true)
     */
    private $discount;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="variants")
     */
    private $article;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string|null
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="article_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     *  @var ArrayCollection
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="variant", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $images;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $stock;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     */
    private $priceProfessional;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     */
    private $priceDealer;

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class, inversedBy="variants", fetch="EAGER")
     */
    private $brand;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    function getImage(): ?string {
        return $this->image;
    }

    function setImage(?string $image): self {
        $this->image = $image;
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

    public function getSize(): ?Size {
        return $this->size;
    }

    public function setSize(?Size $size): self {
        $this->size = $size;

        return $this;
    }

    public function getColor(): ?Color {
        return $this->color;
    }

    public function setColor(?Color $color): self {
        $this->color = $color;

        return $this;
    }

    public function getPrice(): ?string {
        return $this->price;
    }

    public function setPrice(string $price): self {
        $this->price = $price;

        return $this;
    }

    public function getDiscounted(): ?bool {
        return $this->discounted;
    }

    public function setDiscounted(bool $discounted): self {
        $this->discounted = $discounted;

        return $this;
    }

    public function getDiscount(): ?string {
        return $this->discount;
    }

    public function setDiscount(?string $discount): self {
        $this->discount = $discount;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): self {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getArticle(): ?\App\Entity\Article {
        return $this->article;
    }

    public function setArticle(?\App\Entity\Article $article): self {
        $this->article = $article;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setVariant($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getVariant() === $this) {
                $image->setVariant(null);
            }
        }

        return $this;
    }

    public function getStock(): ?bool
    {
        return $this->stock;
    }

    public function setStock(?bool $stock): self
    {
        $this->stock = $stock;

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

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

}
