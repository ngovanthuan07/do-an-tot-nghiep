<?php

namespace App\Http\Controllers\Salon;

use App\Http\Controllers\Controller;
use App\Http\Requests\Salon\CategoryServiceRequest;
use App\Models\CategoryService;
use App\Repositories\CategoryServiceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryServiceController extends Controller
{

    /**
     * @var CategoryServiceRepository
     */
    private $categoryServiceRepository;

    public function __construct(CategoryServiceRepository $categoryServiceRepository)
    {
        $this->categoryServiceRepository = $categoryServiceRepository;
    }

    public function displayCategoryServices()
    {
        return view('components.salon.category-service.list-category-service');
    }

    public function apiCategoryServices()
    {
        return $this->categoryServiceRepository->getAllCategoryServiceBySalonId(Auth::guard('salon')->user()->salon_id);
    }


    public function displayAddCategoryService()
    {
        return view('components.salon.category-service.add');
    }

    public function displayUpdateCategoryService(Request $request)
    {
        $categoryService = CategoryService::query()->where('cse_id', $request['id'])->first();

        return view('components.salon.category-service.edit', compact('categoryService'));
    }

    public function store(Request $request) {
        $this->categoryServiceRepository->create($request);

        return response()->json([
            'success' => true
        ]);
    }

    public function validateCategory(CategoryServiceRequest $request) {
        return response()->json([
            'success' => true
        ]);
    }

    public function update(Request $request) {

        $this->categoryServiceRepository->update($request, $request->input('cse_id'));

        return response()->json([
            'success' => true
        ]);
    }

    public function updateStatus(Request $request) {

        $this->categoryServiceRepository->updateByStatus($request, $request->input('cse_id'));

        return response()->json([
            'success' => true
        ]);
    }
}
