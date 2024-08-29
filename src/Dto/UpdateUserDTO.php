<?php


namespace DTO;

class UpdateUserDTO
{
    private ?string $name;
    private ?string $email;
    private ?string $password;
    private ?bool $isActive;
    private ?int $id;

    public function __construct(?string $name = null, ?string $email = null, ?string $password = null, ?bool $isActive = true, ?int $id = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->isActive = $isActive;
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
