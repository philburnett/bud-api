<?php declare(strict_types=1);

namespace BudApi\Security;

interface TokenStorageInterface
{
    /**
     * Store token
     *
     * @param array $token
     * @return mixed
     */
    public function store(array $token);

    /**
     * Get a token
     *
     * @return array
     */
    public function get(): array;

    /**
     * Is there a token in storage
     *
     * @return bool
     */
    public function hasToken(): bool;
}
