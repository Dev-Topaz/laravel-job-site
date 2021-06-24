<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_influencer extends Model
{
    use HasFactory;

    protected $table = 'category_influencer';
    protected $fillable = [
      'influencer_id', 'category_id,'
    ];

    public function influencers() {
      $this->belongsTo(Influencers::class, 'id', 'influencer_id');
    }

    public function cateogry() {
        $this->belongsTo(Category::class, 'id', 'category_id');
    }
}
