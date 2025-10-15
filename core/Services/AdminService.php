<?php

namespace Core\Services;

class AdminService {
    protected array $items = [];

    public function allowContent(string $key, string $item): void {
        $this->items[$key] = $item;
    }

    public function allowContentMultiple(array $items): void {
        foreach ($items as $key => $item) {
            $this->allowContent($key, $item);
        }
    }

    public function getAllowedContent(): array {
        return collect($this->items)
            ->toArray();
    }

}
