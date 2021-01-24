<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Product extends Model implements TranslatableContract
{
    use HasFactory,Translatable;
    protected $guarded =[];
    public $translatedAttributes = ['name' , 'description'];
    protected $appends=['image_path' , 'profit_percent'];

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }//end of relastionShip

    public function getImagePathAttribute($q)
    {
        return asset('assets/dashboard/ProductImage/'.$this->image);
    }//end of get image path

    public function getProfitPercentAttribute()
    {

        $profit = $this->sale_price -  $this->purchase_price;
        $profit_percent = $profit * 100 / $this->purchase_price;
        return number_format($profit_percent , 2) ;

    }//end of get profit percent

   public function order()
   {
       return $this->belongsToMany(Order::class, 'product_order' , 'product_id');
   }//end of order relations

}//End Of Model
