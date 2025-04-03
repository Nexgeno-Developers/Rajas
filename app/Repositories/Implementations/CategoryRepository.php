<?php

namespace App\Repositories\Implementations;


use App\Entities\Category;
use App\Repositories\Interfaces\ICategoryRepository;

class CategoryRepository implements ICategoryRepository
{

    public function __construct()
    {
    }

    public function get()
    {
        return Category::all();
    }

    public function getById($id)
    {
        return Category::find($id);
    }

    public function insert(Category $category)
    {
       $category->save();
       return $category;
    }

    public function update(Category $category)
    {
        $category->update();
        return $category;
    }

    public function delete($id)
    {
        return $this->getById($id)->delete();
    }
}