<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{


    public function index(Request $request)
    {

        $orders =  Order::whereHas('client' , function($q) use($request){
            return $q->where('name' , 'like' , '%'. $request->search .'%');
        })->paginate(pages_count);
        return view('dashboard.Orders.index' , compact('orders'));

    } //end of index

    public function products(Request $request , Order $order)
    {

        $products = $order->products;

        return view('dashboard.clients.orders._products' , compact('order','products'));

    } //end of products



    public function create()
    {
        //
    } //end of create



    public function store(Request $request)
    {
        //
    } //end of store



    public function show(Order $order)
    {
        //
    } //end of show



    public function edit(Order $order)
    {
        //
    } //end of edit



    public function update(Request $request, Order $order)
    {
        //
    } //end of update



    public function destroy(Order $order)
    {


        foreach ($order->products as $product) {

            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);

        }

        $order->delete();

        return redirect()->route('dashboard.orders.index')->with(['msg'=>'success']);

    } //end of destroy
}
