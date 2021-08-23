<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;
    protected $fillable = [
        'original_url',
    ];

    public function create_slug()
    {
        $char = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $randomString = '';
        for ($i = 0; $i < 5; $i++) {
            $randomString .= $char[rand(0, strlen($char) - 1)];
        }
        return $randomString;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clicks()
    {
        return $this->hasMany(Click::class, 'url_id');

    }

    public function chart_arrays()
    {
        $arr = [];
        $click_arr = $this->clicks->sortBy('created_at');

        foreach ($click_arr as $click) {
            $arr['browser'][$click->browser] = 0;
            $arr['platform'][$click->platform] = 0;
            $arr['language'][$click->language] = 0;
            $arr['visitor'][$click->visitor] = 0;
            $arr['clicks'][date('m-d-Y', strtotime('0 day', strtotime($click->created_at)))] = 0;
        }

        foreach ($this->clicks as $click) {
            $arr['browser'][$click->browser] += 1;
            $arr['platform'][$click->platform] += 1;
            $arr['language'][$click->language] += 1;
            $arr['visitor'][$click->visitor] += 1;
            $arr['clicks'][date('m-d-Y', strtotime('0 day', strtotime($click->created_at)))] += 1;

        }
        return $arr;
    }
}
