<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_brand extends Model
{
    use HasFactory;

    protected $table = "category_brand";

    protected $fillable = [
        'brand_id, ctegory_id'
    ];

    public function categories() {
        return $this->belongsTo(Category::class, "category_id", "id");
    }

    public function brands() {
        return $this->belongsTo(Brands::class, "brand_id", "id");
    }
}
