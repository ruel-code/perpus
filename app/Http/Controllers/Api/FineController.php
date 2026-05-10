<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fine;
use App\Http\Requests\UpdateFineStatusRequest;
use App\Http\Resources\FineResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class FineController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $fines = Fine::all();
        return $this->success(FineResource::collection($fines), 'Fines retrieved successfully');
    }

    public function show(Fine $fine)
    {
        return $this->success(new FineResource($fine), 'Fine retrieved successfully');
    }

    public function update(UpdateFineStatusRequest $request, Fine $fine)
    {
        $fine->update($request->validated());
        return $this->success(new FineResource($fine), 'Fine status updated successfully');
    }
}
