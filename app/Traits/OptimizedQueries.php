<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

/**
 * Trait for optimized database queries with caching support.
 */
trait OptimizedQueries
{
    /**
     * Get cached count for a query.
     */
    public static function cachedCount(string $cacheKey, int $ttl = 300, ?callable $queryModifier = null): int
    {
        return Cache::remember($cacheKey, $ttl, function () use ($queryModifier) {
            $query = static::query();
            
            if ($queryModifier) {
                $queryModifier($query);
            }
            
            return $query->count();
        });
    }

    /**
     * Get cached sum for a column.
     */
    public static function cachedSum(string $column, string $cacheKey, int $ttl = 300, ?callable $queryModifier = null): float
    {
        return Cache::remember($cacheKey, $ttl, function () use ($column, $queryModifier) {
            $query = static::query();
            
            if ($queryModifier) {
                $queryModifier($query);
            }
            
            return (float) $query->sum($column);
        });
    }

    /**
     * Scope for eager loading common relationships.
     */
    public function scopeWithCommonRelations(Builder $query): Builder
    {
        $relations = $this->getCommonRelations();
        
        if (!empty($relations)) {
            $query->with($relations);
        }
        
        return $query;
    }

    /**
     * Get common relations to eager load.
     * Override in model to specify relations.
     */
    protected function getCommonRelations(): array
    {
        return [];
    }

    /**
     * Scope for selecting only essential columns.
     */
    public function scopeSelectEssential(Builder $query): Builder
    {
        $columns = $this->getEssentialColumns();
        
        if (!empty($columns)) {
            $query->select($columns);
        }
        
        return $query;
    }

    /**
     * Get essential columns for list views.
     * Override in model to specify columns.
     */
    protected function getEssentialColumns(): array
    {
        return ['*'];
    }

    /**
     * Scope for cursor-based pagination (more efficient for large datasets).
     */
    public function scopeCursorPaginated(Builder $query, int $perPage = 15, string $cursor = null): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        return $query->cursorPaginate($perPage, ['*'], 'cursor', $cursor);
    }

    /**
     * Scope for chunked processing of large datasets.
     */
    public function scopeProcessInChunks(Builder $query, int $chunkSize, callable $callback): void
    {
        $query->chunk($chunkSize, $callback);
    }

    /**
     * Scope for lazy collection (memory efficient for large datasets).
     */
    public function scopeLazyCollection(Builder $query, int $chunkSize = 100): \Illuminate\Support\LazyCollection
    {
        return $query->lazy($chunkSize);
    }
}
