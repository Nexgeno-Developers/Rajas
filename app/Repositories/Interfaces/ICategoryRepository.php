<?php

namespace App\Repositories\Interfaces;


use App\Entities\Category;

interface ICategoryRepository
{
    public function __construct();

    public function get();

    public function getById($id);

    public function insert(Category $category);

    public function update(Category $category);

    public function delete($id);
}