<?php

namespace App\Http\Controllers;

use App\Entities\Setting;
use App\Entities\Category;
use App\Traits\Pagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CategoryValidation;
use App\Http\Services\Interfaces\ICategoryService;

class CategoryController extends Controller
{
    use Pagination;

    protected $category, $service, $custom;

    public function __construct(ICategoryService $category)
    {
        $this->custom = Setting::first();
        $this->category = $category;
        view()->share('custom', $this->custom);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('categories', Auth::user());
        if($request->has('page') && $request->page > 1) {
            $rowIndex = (($request->page - 1) * 10) + 1;
        } else {
            $rowIndex = 1;
        }
        $categories = Category::where('user_id',Auth::user()->id)->orderBy('id','DESC')->get();
        return view('categories.index',compact('categories','rowIndex'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $custom = Setting::first();
        $this->authorize('categories', Auth::user());
        $categories = Category::where('user_id',Auth::user()->id)->get();
        return view('categories.create',compact('categories','custom'));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryValidation $request)
    {
        $this->authorize('categories', Auth::user());
        $this->category->insert(new Category($request->all()));
        session()->flash('message', trans('Category created successfully'));
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $custom = Setting::first();
        $this->authorize('categories', Auth::user());
        $category = Category::where('name',$category->name)->where('user_id',Auth::user()->id)->first();
        if(empty($category)) {
            return redirect()->back();
        }
        return view('categories.show',compact('category','custom'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $custom = Setting::first();
        $this->authorize('categories', Auth::user());
        $category = Category::where('id',$id)->where('user_id',Auth::user()->id)->first();
        if(empty($category)) {
            return redirect()->back();
        }
        return view('categories.edit',compact('category','custom'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryValidation $request, Category $category)
    {
        $this->authorize('services', Auth::user());
        $this->category->update($category->fill($request->all()));
        session()->flash('message', trans('Category updated successfully'));
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $this->authorize('categories', Auth::user());
        $this->category->delete($category->id);
        session()->flash('message', trans('Category deleted successfully'));
        return redirect()->route('categories.index');
    }
}
