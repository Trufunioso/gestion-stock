<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
class Message
{
    /**
     * @var string
     */
    #[Assert\Email]
    #[Assert\NotBlank]
    private $email;

    /**
     * @var string
     */
    #[Assert\NotBlank(message: 'Ce champ est requis')]
    #[Assert\Length(max: 1000, min: 10, maxMessage: 'Trop long', minMessage: 'Trop court')]
    private $content;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Message
     */
    public function setEmail(string $email): Message
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Message
     */
    public function setContent(string $content): Message
    {
        $this->content = $content;
        return $this;
    }

}