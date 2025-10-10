<?php

namespace Core\Services;

class MenuService {
    protected array $items = [];

    public function register(string $key, array $item): void {
        $this->items[$key] = $item;
    }

    public function registerMultiple(array $items): void {
        foreach ($items as $key => $item) {
            $this->register($key, $item);
        }
    }

    public function all(): array {
        return collect($this->items)
            ->sortBy('order')
            ->toArray();
    }

    public function getByGroup(string $group): array {
        return collect($this->items)
            ->where('group', $group)
            ->sortBy('order')
            ->toArray();
    }
}
