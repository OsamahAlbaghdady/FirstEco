<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriesRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    public function index(Request $request)
    {

        $categories = Category::when($request->search , function($q) use($request){
           return $q->whereTranslationLike('name' , '%'.$request->search.'%');
        })->latest()->paginate(pages_count);
        return view('dashboard.categories.index', compact('categories'));
    } //End Of Index

    public function create()
    {
        return view('dashboard.categories.create');
    } //End Of Create


    public function store(CategoriesRequest $request)
    {

        $request = $request->except(['_token','_method']);
        Category::create($request);
        return redirect()->route('dashboard.categories.index')->with(['success' => 'تم انشاء القسم بنجاح']);
    } //End Of Store


    public function show(Category $category)
    {
        //
    }


    public function edit(Category $category)
    {
        try {
            if (!$category) {
                return redirect()->route('dashboard.categories.index')->with(['error' => __('site.error')]);
            }
            return view('dashboard.categories.edit', compact('category'));
        } catch (\Exception $ex) {
            return $ex;
        }
    } //End Of Edit


    public function update(CategoriesRequest $request, Category $category)
    {
        try {
            if (!$category) {
                return redirect()->route('dashboard.categories.index')->with(['error' => __('site.error')]);
            }
            $categories = $request->except(['_token', '_method', 'id']);
            $category->update($categories);
            return redirect()->route('dashboard.categories.index')->with(['msg' => __('site.success')]);
        } catch (\Exception $ex) {
            return redirect()->route('dashboard.categories.index')->with(['error' => __('site.error')]);
        }
    } //End Of Update


    public function destroy(Category $category)
    {
        try {
            if (!$category) {
                return redirect()->route('dashboard.categories.index')->with(['error' => __('site.error')]);
            }
            $category->delete();
            return redirect()->route('dashboard.categories.index')->with(['msg' => __('site.success')]);
        } catch (\Exception $ex) {
            return redirect()->route('dashboard.categories.index')->with(['error' => __('site.error')]);
        }
    } //End Of delete

}//End Of Controller
