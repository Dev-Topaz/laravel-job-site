<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Brands extends Model
{
    use HasFactory;

    protected $table = "brands";

    protected $fillable = [
        'user_id',
    ];

    public function user() {
        return $this->belongsTo(User::class, "user_id", 'id');
    }

    public function category() {
        return $this->hasManyThrough(Category::class, Category_brand::class, "brand_id", "id", "id", "category_id");
    }

    public function profile() {
        return $this->hasOneThrough(Profile::class, User::class, 'id', "user_id", 'user_id', "id");
    }

    public function accountInfo() {
        return $this->hasOne(BrandInfo::class, "brand_id", "id");
    }

    public function getUsers($name='', $category='', $location='', $keyword='', $perPage=10) {
        return Brands::with('user', 'accountInfo', 'category', 'profile')
            ->whereHas('user', function($q) use($name) {
            if($name != '')
                $q->where('username', 'LIKE', '%'.$name.'%')
                ->orWhere('name', "LIKE", '%'.$name.'%');
        })->whereHas('accountInfo', function($q) use($location) {
            if($location != '')
                $q->where('country', '=', $location);
        })->whereHas('category', function($q) use($category) {
            if($category != '')
                $q->where('id', '=', (int)$category);
        })->paginate($perPage);
    }
}
