<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\MoneyHelper;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    protected $fillable = ['code'];
    /**
     * @return string
     */
    public function priceFormatted(): string
    {
        return MoneyHelper::format($this->price, config('app.monetary_locale'));
    }

    /**
     * @param Builder $query
     * @param string|null $name
     * @return Builder
     */
    public function scopeName(Builder $query, ?string $name): Builder
    {
        if ($name) {
            return $query->orWhere('name', 'like', "%$name%");
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @param string|null $code
     * @return Builder
     */
    public function scopeCode(Builder $query, ?string $code): Builder
    {
        if ($code) {
            return $query->orWhere('code', $code);
        }

        return $query;
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if ($term) {
            return $this->name($term)->code($term);
        }

        return $query;
    }
}
