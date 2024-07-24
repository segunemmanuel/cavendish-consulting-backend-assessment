<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Website extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['category_names', 'vote_count'];

    protected $with = ['categories', 'votes']; // Eager load categories and votes

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    // Accessor for category names
    public function getCategoryNamesAttribute()
    {
        return $this->categories->pluck('name');
    }

    // Accessor for vote count
    public function getVoteCountAttribute()
    {
        return $this->votes->count();
    }
}
