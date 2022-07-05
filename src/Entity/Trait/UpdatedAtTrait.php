<?php
 namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

 Trait UpdatedAtTrait {
    #[ORM\Column(type: 'datetime')]
    private $updated_at;

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
 }