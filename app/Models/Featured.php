<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Featured extends Model
{
    use HasFactory;

    protected $table = 'featured';

    protected $fillable = ['user_id'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    } 

    public function influencers_info() {
        return $this->hasOneThrough(InfluencerInfo::class, Influencers::class, 'id', 'influencer_id', 'user_id', 'user_id');
    }

    public function getFeaturedInfluencers() {
        return Featured::with('user', 'user.influencersInfo', 'user.profile')->orderBy('created_at', 'desc')->limit(4)->get();
    }
}