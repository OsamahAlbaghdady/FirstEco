<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class);

    } //end of relasion

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_order' , 'order_id')->withPivot('quantity');

    } //end of product relastion
}
