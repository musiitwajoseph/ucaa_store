<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterData extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'master_data';

    protected $fillable = [
        'category_id',
        'code',
        'name',
        'description',
        'type',
        'unit',
        'value',
        'metadata',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
        'metadata' => 'array',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(MasterDataCategory::class, 'category_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('name');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('code', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('type', 'like', "%{$search}%");
        });
    }

    // Accessors
    public function getCategoryNameAttribute()
    {
        return $this->category ? $this->category->name : 'Uncategorized';
    }
}
