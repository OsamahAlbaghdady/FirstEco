<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Client;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{

    public function index()
    {

       $categories_count = Category::count();
       $products_count = Product::count();
       $clients_count = Client::count();
       $users_count = User::count();

       return view('dashboard.welcome' , compact('categories_count' , 'products_count' , 'clients_count' , 'users_count'));

    }//end of index

}//end of controller
