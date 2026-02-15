<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document]
class AppointmentMetadata
{
    #[MongoDB\Id]
    private ?string $id = null;

    #[MongoDB\Field(type: 'int')]
    private ?int $appointmentId = null;

    #[MongoDB\Field(type: 'string')]
    private ?string $notes = null;

    #[MongoDB\Field(type: 'collection')]
    private array $preferences = [];

    #[MongoDB\Field(type: 'collection')]
    private array $history = [];

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getAppointmentId(): ?int
    {
        return $this->appointmentId;
    }

    public function setAppointmentId(int $appointmentId): static
    {
        $this->appointmentId = $appointmentId;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }

    public function getPreferences(): array
    {
        return $this->preferences;
    }

    public function setPreferences(array $preferences): static
    {
        $this->preferences = $preferences;

        return $this;
    }

    public function getHistory(): array
    {
        return $this->history;
    }

    public function setHistory(array $history): static
    {
        $this->history = $history;

        return $this;
    }
}
