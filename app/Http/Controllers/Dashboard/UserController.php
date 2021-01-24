<?php

namespace App\Http\Controllers\Dashboard;

require 'vendor/autoload.php';


use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic as Image;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:read_users'])->only('index');
        $this->middleware(['permission:create_users'])->only('create');
        $this->middleware(['permission:update_users'])->only('update');
        $this->middleware(['permission:update_users'])->only('edit');
        $this->middleware(['permission:delete_users'])->only('destroy');
    }

    public function index(Request $request)
    {
        $users = User::whereRoleIs('admin')->where(function ($q) use ($request) {
            return $q->when($request->search, function ($query) use ($request) {
                return $query->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%');
            });
        })->latest()->paginate(pages_count);


        return view('dashboard.users.index', compact('users'));
    } //end index


    public function create()
    {
        return view('dashboard.users.create');
    }

    public function store(UserRequest $request)
    {

        // return public_path()." ".base_path('public');
        $request_data = $request->except(['password', 'password_confirmation', 'permissions', 'image']);
        $request_data['password'] = bcrypt($request->password);
        if ($request->image) {
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(base_path('assets/dashboard/UserImages/') . $request->image->hashName());
            $request_data['image'] = $request->image->hashName();
        }
        $users = User::create($request_data);
        $users->attachRole('admin');
        if (isset($request->permissions)) {
            $users->syncPermissions($request->permissions);
        }
        return redirect()->route('dashboard.users.index')->with(['msg' => __('site.success')]);

        try {
            //
        } catch (\Throwable $th) {
            //throw $th;
        }
    } //end of store

    public function edit(User $user)
    {

        if (!$user) {
            return redirect()->route('dashboard.users.index');
        }

        return view('dashboard.users.edit', compact('user'));
    }


    public function update(UserRequest $request, User $user)
    {

        $request_data = $request->except(['permissions', 'image']);

        if (!$user) {
            return redirect()->route('dashboard.users.index')->with(['msg' => __('site.error')]);
        }
        if (isset($request->permissions)) {
            $user->syncPermissions($request->permissions);
        }

        if ($request->image) {
            if ($user->image != 'default.png') {

                Storage::disk('users_uploads')->delete($user->image);
            } //end of inner if
            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(base_path('assets/dashboard/UserImages/') . $request->image->hashName());

            $request_data['image'] = $request->image->hashName();
        }

        $user->update($request_data);

        return redirect()->route('dashboard.users.index')->with(['msg' => __('site.success')]);
    }

    public function destroy(User $user)
    {
        if (!$user) {
            return redirect()->route('dashboard.users.index')->with(['msg' => __('site.error')]);
        }
        if ($user->image != 'default.png') {
            Storage::disk('users_uploads')->delete($user->image);
        } //end of if
        $user->delete();
        return redirect()->route('dashboard.users.index')->with(['msg' => __('site.success')]);
    } //End Of Delete
}
