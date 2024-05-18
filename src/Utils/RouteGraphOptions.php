<?php

declare(strict_types=1);

namespace Henrik\Route\Utils;

class RouteGraphOptions
{
    public function __construct(private string $groupName) {}

    public function getGroupName(): string
    {
        return $this->groupName;
    }

    public function setGroupName(string $groupName): void
    {
        $this->groupName = $groupName;
    }
}