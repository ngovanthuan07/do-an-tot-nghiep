<?php

namespace App\Repositories;

use App\Models\CategoryService;
use App\Models\Salon;
use Illuminate\Support\Facades\Auth;

class CategoryServiceRepository
{
    public function create($request) {
        $categoryService = new CategoryService();
        $categoryService->name = $request->input('name');
        $categoryService->salon_id = Auth::guard('salon')->user()->salon_id;
        $categoryService->isSelect = $request->input('isSelect');
        $categoryService->status = 'ON';
        $categoryService->save();
        return $categoryService ? true : false;
    }

    public function update($request, $id) {
        $categoryService = CategoryService::query()->where('cse_id', $id)->first();
        $categoryService->name = $request->input('name');
        $categoryService->isSelect = $request->input('isSelect');
        $categoryService->salon_id = Auth::guard('salon')->user()->salon_id;
        $categoryService->status = 'ON';
        $categoryService->update();
    }

    public function updateByStatus($request, $id) {
        $categoryService = CategoryService::query()->where('cse_id', $id)->first();
        $categoryService->status = $request->input('status');
        $categoryService->update();
    }

    public function getAllCategoryServiceBySalonId($id) {
        return CategoryService::query()
            ->where('salon_id', $id)
            ->where('status', 'ON')->get();
    }
}
