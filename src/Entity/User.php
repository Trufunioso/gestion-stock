<?php

namespace App\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class User
{
    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var \DateTime
     */
    private $birthDate;

    /**
     * @var boolean
     */
    private $consent;

    /**
     * @var string
     */
    private $titre;

    /**
     * @var UploadedFile
     */
    private $cv;

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return User
     */
    public function setLastName(string $lastName): User
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return User
     */
    public function setFirstName(string $firstName): User
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBirthDate(): \DateTime
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTime $birthDate
     * @return User
     */
    public function setBirthDate(\DateTime $birthDate): User
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    /**
     * @return bool
     */
    public function isConsent(): bool
    {
        return $this->consent;
    }

    /**
     * @param bool $consent
     * @return User
     */
    public function setConsent(bool $consent): User
    {
        $this->consent = $consent;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitre(): string
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     * @return User
     */
    public function setTitre(string $titre): User
    {
        $this->titre = $titre;
        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getCv(): ?UploadedFile
    {
        return $this->cv;
    }

    /**
     * @param UploadedFile $cv
     * @return User
     */
    public function setCv(UploadedFile $cv): User
    {
        $this->cv = $cv;
        return $this;
    }
}