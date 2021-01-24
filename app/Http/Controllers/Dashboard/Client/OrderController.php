<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function create(Client $client , Order $order)
    {
        $categories = Category::with('products')->get();

        $orders = $client->orders()->with('products')->paginate(pages_count);

        return view('dashboard.clients.orders.create', compact('client', 'categories' , 'orders'));
    } //end of create

    public function store(OrderRequest $request, Client $client)
    {

        $this->attach_order($request , $client);

        return redirect()->route('dashboard.clients.index')->with(['msg' => __('site.success')]);


    } //end of store




    public function edit(Client $client, Order $order)
    {
        $categories = Category::with('products')->get();
        $orders = $client->orders()->with('products')->paginate(pages_count);
        return view('dashboard.clients.orders.edit', compact('categories', 'client', 'orders' , 'order'));
    } //end of edit

    public function update(OrderRequest $request, Client $client, Order $order)
    {

        $this->de_Attach_order($order);

        $this->attach_order($request , $client);

        return redirect()->route('dashboard.clients.index')->with(['msg' => __('site.success')]);


    } //end of update



    private function attach_order($request, $client)
    {

        try {
            $order = $client->orders()->create([]);
            $order->products()->attach($request->products);

            $total_price = 0;

            foreach ($request->products as $id => $product) {

                $pro = Product::findOrFail($id);
                $total_price += $pro->sale_price * $product['quantity'];
                $pro->update([
                    'stock' => $pro->stock - $product['quantity'],
                ]);
            } //end of foreach

            $order->update([
                'total_price' => $total_price
            ]); //end of update

        } catch (\Exception $ex) {
            return redirect()->route('dashboard.clients.index')->wiht(['error' => 'site.error']);
        }
    } //end of attach orders

    private function de_Attach_order($order)
    {

        foreach ($order->products as $product) {

            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);
        }

        $order->delete();
    } //end of de attach server

}//end of controller
