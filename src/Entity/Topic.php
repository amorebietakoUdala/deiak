<?php

namespace App\Entity;

use App\Repository\TopicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: TopicRepository::class)]
class Topic implements \Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups('api_get_consultation_topics')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups('api_get_consultation_topics')]
    private $descriptionEs;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups('api_get_consultation_topics')]
    private $descriptionEu;

    #[ORM\JoinTable(name: 'consultation_topic')]
    #[ORM\ManyToMany(targetEntity: Consultation::class, mappedBy: 'topic')]
    #[Ignore]
    private Collection|array $consultations;

    public function __construct()
    {
        $this->consultations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return Collection|Consultation[]
     */
    #[Groups('not_serialize')]
    #[Ignore]
    public function getConsultations(): Collection
    {
        return $this->consultations;
    }

    #[Groups('not_serialize')]
    #[Ignore]
    public function addConsultation(Consultation $consultation): self
    {
        if (!$this->consultations->contains($consultation)) {
            $this->consultations[] = $consultation;
            $consultation->addTopic($this);
        }

        return $this;
    }

    #[Groups('not_serialize')]
    #[Ignore]
    public function removeConsultation(Consultation $consultation): self
    {
        if ($this->consultations->removeElement($consultation)) {
            $consultation->removeTopic($this);
        }

        return $this;
    }

    /**
     * Get the value of descriptionEs
     */
    public function getDescriptionEs()
    {
        return $this->descriptionEs;
    }

    /**
     * Set the value of descriptionEs
     *
     * @return  self
     */
    public function setDescriptionEs($descriptionEs)
    {
        $this->descriptionEs = $descriptionEs;

        return $this;
    }

    /**
     * Get the value of descriptionEu
     */
    public function getDescriptionEu()
    {
        return $this->descriptionEu;
    }

    /**
     * Set the value of descriptionEu
     *
     * @return  self
     */
    public function setDescriptionEu($descriptionEu)
    {
        $this->descriptionEu = $descriptionEu;

        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->getDescriptionEs();
    }
}
