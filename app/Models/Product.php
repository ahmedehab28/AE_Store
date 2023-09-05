<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    // protected $primaryKey = 'product_id';
    // protected $fillable = 'product_name'; // if u wanna make laravel allow this field to be allowed to be edited
    protected $guarded = [];            // this is another way to make laravel to allow all fields to be edited (as there is nothing in guarded)
    public $timestamps = false;

    function category () {
        return $this->belongsTo(Category::class);
    }
}
