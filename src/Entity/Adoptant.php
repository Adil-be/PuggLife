<?php

namespace App\Entity;

use App\Repository\AdoptantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AdoptantRepository::class)]
class Adoptant extends User
{
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    protected ?string $firstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    protected ?string $lastName = null;

    /**
     * @var Collection<int, AdoptionOffer>
     */
    #[ORM\OneToMany(mappedBy: 'adoptant', targetEntity: AdoptionOffer::class, cascade: ['persist', 'remove'])]
    protected Collection $adoptionOffers;

    public function __construct()
    {
        $this->adoptionOffers = new ArrayCollection();
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection<int, AdoptionOffer>
     */
    public function getAdoptionOffers(): Collection
    {
        return $this->adoptionOffers;
    }

    public function addAdoptionOffer(AdoptionOffer $adoptionOffer): self
    {
        if (!$this->adoptionOffers->contains($adoptionOffer)) {
            $this->adoptionOffers->add($adoptionOffer);
            $adoptionOffer->setAdoptant($this);
        }

        return $this;
    }

    public function removeAdoptionOffer(AdoptionOffer $adoptionOffer): self
    {
        if ($this->adoptionOffers->removeElement($adoptionOffer)) {
            // set the owning side to null (unless already changed)
            if ($adoptionOffer->getAdoptant() === $this) {
                $adoptionOffer->setAdoptant(null);
            }
        }

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        // Add role Adoptant to adoptant
        $roles[] = 'ROLE_ADOPTANT';

        return array_unique($roles);
    }

    public function hasAlreadyApply(Annonce $annonce): bool
    {
        foreach ($this->getAdoptionOffers() as $offer) {
            if ($offer->getAnnonce() == $annonce) {
                return true;
            }
        }

        return false;
    }

    public function __toString(): string
    {
        return (string) $this->getEmail();
    }
}
