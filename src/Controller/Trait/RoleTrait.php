<?php

namespace App\Controller\Trait;

Trait RoleTrait
{
    protected function checkRole(string $role)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('authentication-login');
        }
        return null;
    }
}