<?php

declare(strict_types=1);

namespace PokMultipleItemToShoppingCart\Core\Content\OrderLog;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class OrderLogEntity extends Entity
{
    use EntityIdTrait;

    protected ?string $name;

    protected ?string $description;

    protected bool $active;

    protected string $sessionId;
    protected $createdAt;
    protected string $products;


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }



    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function setSessionId(string $sessionId): void
    {
        $this->sessionId = $sessionId;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getProducts(): string
    {
        return $this->products;
    }

    public function setProducts(string $products): void
    {
        $this->products = $products;
    }
}
