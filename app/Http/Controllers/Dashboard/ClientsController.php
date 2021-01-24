<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ClientsController extends Controller
{

    public function index(Request $request)
    {
        $clients = Client::when($request->search, function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search . '%')
            ->orWhere('phone', 'like', '%' . $request->search . '%')
            ->orWhere('address', 'like', '%' . $request->search . '%');
        })->latest()->paginate(pages_count);

        return view('dashboard.clients.index', compact('clients'));
    } //End Of Index

    public function create()
    {
        return view('dashboard.clients.create');
    } //End Of create


    public function store(ClientRequest $request)
    {
        $request_data = $request->except(['_token', '_method', 'image']);

        if ($request->image) {
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(base_path('assets/dashboard/ClientImage/') . $request->image->hashName());
            $request_data['image'] = $request->image->hashName();
        }
        Client::create($request_data);
        return redirect()->route('dashboard.clients.index')->with(['msg' => __('site.success')]);
    } //End Of store


    public function show(Client $client)
    {
        //
    } //End Of show


    public function edit(Client $client)
    {

        return view('dashboard.clients.edit', compact('client'));
    } //End Of edit


    public function update(ClientRequest $request, Client $client)
    {
        $request_data = $request->except(['_method', '_token', 'image']);
        if ($request->image) {
            if ($client->image != 'default.png') {
                Storage::disk('clients_uploads')->delete($client->image);
            }

            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(base_path('assets/dashboard/ClientImage/') . $request->image->hashName());
            $request_data['image'] = $request->image->hashName();
        }
        $client->update($request_data);
        return redirect()->route('dashboard.clients.index')->with(['msg' => __('site.success')]);
    } //End Of update

    public function destroy(Client $client)
    {
        if ($client->image != 'default.png') {

            Storage::disk('clients_uploads')->delete($client->image);
        }

        $client->delete();

        return redirect()->route('dashboard.clients.index')->with(['msg' => __('site.success')]);

    } //End Of destroy

}
