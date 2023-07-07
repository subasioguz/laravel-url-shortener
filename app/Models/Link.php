<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Link extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'title', 'slug'];

    public function visits(): HasMany
    {
        return $this->hasMany(LinkVisit::class);
    }

    public function getTotalVisitorsAttribute(): int
    {
        return $this->visits()->distinct()->count('ip_address');
    }

    protected function slug(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => url($value),
            set: fn (string $value) => Str::slug($value, '-')
        );
    }
}
