<?php

namespace App\Http\Services\Interfaces;

use App\Entities\Category;
use App\Repositories\Interfaces\ICategoryRepository;

interface ICategoryService
{
    public function __construct(ICategoryRepository $categoryRepository);

    public function get();

    public function getById($id);

    public function insert(Category $service);

    public function update(Category $service);

    public function delete($id);
}