<?php
/**
 * Created by PhpStorm.
 * User: irfan
 * Date: 18-10-21
 * Time: 3.16.MD
 */

namespace App\Http\Services\Implementations;


use App\Entities\Category;
use App\Http\Categories\Interfaces\ICategory;
use App\Http\Services\Interfaces\ICategoryService;
use App\Repositories\Interfaces\ICategoryRepository;

class CategoryService implements ICategoryService
{
    protected $serviceRepository;

    public function __construct(ICategoryRepository $serviceRepository)
    {
        $this->serviceRepository =  $serviceRepository;
    }

    public function get()
    {
        return $this->serviceRepository->get();
    }

    public function getById($id)
    {
        return $this->serviceRepository->getById($id);
    }

    public function insert(Category $service)
    {
        return $this->serviceRepository->insert($service);
    }

    public function update(Category $service)
    {
        return $this->serviceRepository->update($service);
    }

    public function delete($id)
    {
        return $this->serviceRepository->delete($id);
    }

}