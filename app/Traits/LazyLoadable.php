<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait for implementing lazy loading in Livewire components.
 */
trait LazyLoadable
{
    /**
     * Default items per page
     */
    public int $perPage = 15;

    /**
     * Maximum items per page
     */
    protected int $maxPerPage = 100;

    /**
     * Whether to use cursor pagination
     */
    protected bool $useCursorPagination = false;

    /**
     * Current cursor for cursor pagination
     */
    public ?string $cursor = null;

    /**
     * Initialize lazy loading settings from config.
     */
    protected function initializeLazyLoading(): void
    {
        $this->perPage = config('performance.pagination.default_per_page', 15);
        $this->maxPerPage = config('performance.pagination.max_per_page', 100);
        $this->useCursorPagination = config('performance.lazy_loading.enable_cursor_pagination', false);
    }

    /**
     * Set items per page with validation.
     */
    public function setPerPage(int $perPage): void
    {
        $this->perPage = min($perPage, $this->maxPerPage);
    }

    /**
     * Get paginated results with appropriate pagination method.
     */
    protected function getPaginatedResults(Builder $query): LengthAwarePaginator|CursorPaginator
    {
        if ($this->useCursorPagination) {
            return $query->cursorPaginate($this->perPage, ['*'], 'cursor', $this->cursor);
        }

        return $query->paginate($this->perPage);
    }

    /**
     * Load more items (for infinite scroll).
     */
    public function loadMore(): void
    {
        $this->perPage += config('performance.lazy_loading.chunk_size', 15);
    }

    /**
     * Reset pagination.
     */
    public function resetPagination(): void
    {
        $this->perPage = config('performance.pagination.default_per_page', 15);
        $this->cursor = null;
        $this->resetPage();
    }

    /**
     * Reset page (to be implemented by Livewire's WithPagination trait).
     */
    protected function resetPage(): void
    {
        if (method_exists($this, 'gotoPage')) {
            $this->gotoPage(1);
        }
    }
}
