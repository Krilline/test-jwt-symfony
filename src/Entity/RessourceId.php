<?php

namespace App\Entity;

trait RessourceId
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"user:read"})
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}