<?php

declare(strict_types=1);

namespace henrik\route\Utils;

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