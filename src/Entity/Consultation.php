<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
class Consultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $startDate;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\JoinTable(name: 'consultation_topic')]
    #[ORM\ManyToMany(targetEntity: Topic::class, inversedBy: 'consultations', cascade: ['persist'])]
    private Collection|array $topic;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $attendedBy = null;

    public function __construct()
    {
        $this->topic = new ArrayCollection();
        $this->startDate = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return Collection|Topic[]
     */
    public function getTopic(): Collection
    {
        return $this->topic;
    }

    public function addTopic(Topic $topic): self
    {
        if (!$this->topic->contains($topic)) {
            $this->topic[] = $topic;
        }

        return $this;
    }

    public function removeTopic(Topic $topic): self
    {
        $this->topic->removeElement($topic);

        return $this;
    }

    public function getAttendedBy(): ?User
    {
        return $this->attendedBy;
    }

    public function setAttendedBy(?User $attendedBy): self
    {
        $this->attendedBy = $attendedBy;

        return $this;
    }

    public function filterToArray(): array
    {
        $consultationArray = [];
        if ( $this->startDate !== null ) {
            $consultationArray['startDate'] = $this->startDate->format('Y-m-d H:i');
        }
        if ( $this->endDate !== null ) {
            $consultationArray['endDate'] = $this->endDate->format('Y-m-d H:i');
        }
        if (count($this->topic) > 0 ) {
            $topics = [];
            foreach($this->getTopic() as $topic) {
                $topics[] = $topic->getId();
            }
            $consultationArray['topic'] = implode(',', $topics);
        }

        return $consultationArray;
    }
}
