<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $fillable = ['name' , 'phone' , 'address' , 'image'];
    protected $appends = ['image_path'];
    protected $casts = [
        'phone'=>'array'
    ];

    public function getImagePathAttribute()
    {
        return asset('assets/dashboard/ClientImage/'.$this->image);

    }//end of get image path

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

public function getNameAttribute($value)
{
     return ucfirst($value);
}//end of upper case name

}
