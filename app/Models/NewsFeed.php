<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsFeed extends Model
{
    use HasFactory;

    protected $table = 'news_feed';

    protected $fillable = [
        'full_name, project_title, description, logo_img, back_img',
    ];
}
