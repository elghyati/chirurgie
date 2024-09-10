<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use PhpParser\Node\Stmt\PropertyProperty;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @Vich\Uploadable
 * @ORM\Table(name="user", indexes={@ORM\Index(name="type_idx", columns={"type"})})
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string", length=3)
 * @ORM\DiscriminatorMap({
 *     "USR"="User",
 *     "EMP"="Employe",
 *     "CST"="Customer",
 * })
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *  fields ={"email"},
 *  message="Un autre utillisateur s'est déjà inscrit avec cette adresse email, merci de la modifier."
 * )
 */
class User implements UserInterface {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $civilite;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank(message="Vous devez renseigner votre prénom!")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank(message="Vous devez renseigner votre nom de famille!")
     */
    private $lastName;

    public function getFullName(): ?string {
        return $this->firstName . " " . $this->lastName;
    }

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Email(message="Veuillez renseigner une adresse mail valide!")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string|null
     */
    private $picture;

    /**
     * @Vich\UploadableField(mapping="user_images", fileNameProperty="picture")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hash;

    /**
     * @Assert\EqualTo(propertyPath="hash", message="Vous n'avez pas bien confirmé votre mot de passe !")
     */
    private $passwordConfirm;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $introduction;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $job;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $codePostal;

    /**
     * @ORM\ManyToMany(targetEntity=Role::class, inversedBy="users")
     */
    private $userRoles;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $tel;

    /**
     * 
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $gsm;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="user")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="user")
     */
    private $comments;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $customerType;

    public function __construct() {
        $this->userRoles = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->comments = new ArrayCollection();
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
            $this->slug = $slugify->slugify($this->firstName . ' ' . $this->lastName);
        }
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getFirstName(): ?string {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(string $email): self {
        $this->email = $email;

        return $this;
    }

    public function getPicture(): ?string {
        return $this->picture;
    }

    public function setPicture(?string $picture): self {
        $this->picture = $picture;

        return $this;
    }

    public function getHash(): ?string {
        return $this->hash;
    }

    public function setHash(string $hash): self {
        $this->hash = $hash;

        return $this;
    }

    function getPasswordConfirm() {
        return $this->passwordConfirm;
    }

    function setPasswordConfirm($passwordConfirm): void {
        $this->passwordConfirm = $passwordConfirm;
    }

    public function getIntroduction(): ?string {
        return $this->introduction;
    }

    public function setIntroduction(?string $introduction): self {
        $this->introduction = $introduction;

        return $this;
    }

    public function getSlug(): ?string {
        return $this->slug;
    }

    public function setSlug(string $slug): self {
        $this->slug = $slug;

        return $this;
    }

    public function getCivilite(): ?string {
        return $this->civilite;
    }

    public function setCivilite(string $civilite): self {
        $this->civilite = $civilite;

        return $this;
    }

    public function getJob(): ?string {
        return $this->job;
    }

    public function setJob(string $job): self {
        $this->job = $job;

        return $this;
    }

    public function getCompany(): ?string {
        return $this->company;
    }

    public function setCompany(string $company): self {
        $this->company = $company;

        return $this;
    }

    public function getAdresse(): ?string {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string {
        return $this->ville;
    }

    public function setVille(string $ville): self {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): self {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function eraseCredentials() {
        
    }

    public function getPassword() {
        return $this->hash;
    }

//    public function getRoles() : string[]{
    public function getRoles() {
        $roles = $this->userRoles->map(function ($role) {
                    return $role->getTitle();
                })->toArray();
        $roles[] = 'ROLE_USER';
        return $roles;
    }

    public function getSalt() {
        
    }

    public function getUsername(): string {
        return $this->email;
    }

    /**
     * @return Collection|\App\Entity\Role[]
     */
    public function getUserRoles(): ?Collection {
        return $this->userRoles;
    }

    public function addUserRole(\App\Entity\Role $userRole): self {
        if (!$this->userRoles || !$this->userRoles->contains($userRole)) {
            $this->userRoles[] = $userRole;
//            dd($this->userRoles);
//            $userRole->addUser($this);
        }

        return $this;
    }

    public function removeUserRole(\App\Entity\Role $userRole): self {
        if ($this->userRoles->contains($userRole)) {
            $this->userRoles->removeElement($userRole);
//            $userRole->removeUser($this);
        }

        return $this;
    }

    public function getEnabled(): ?bool {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): self {
        $this->enabled = $enabled;

        return $this;
    }

    public function getTel(): ?string {
        return $this->tel;
    }

    public function setTel(?string $tel): self {
        $this->tel = $tel;

        return $this;
    }

    public function getGsm(): ?string {
        return $this->gsm;
    }

    public function setGsm(string $gsm): self {
        $this->gsm = $gsm;

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

    public function getUpdatedAt(): ?\DateTimeInterface {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setUser($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getUser() === $this) {
                $order->setUser(null);
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

    public function getCustomerType(): ?string
    {
        return $this->customerType;
    }

    public function setCustomerType(?string $customerType): self
    {
        $this->customerType = $customerType;

        return $this;
    }

}
