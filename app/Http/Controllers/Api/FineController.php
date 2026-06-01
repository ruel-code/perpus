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
        $fines = Fine::with(['loan.user', 'loan.book', 'user'])->get();
        return $this->success(FineResource::collection($fines), 'Fines retrieved successfully');
    }

    public function show(Fine $fine)
    {
        return $this->success(new FineResource($fine->load(['loan.user', 'loan.book', 'user'])), 'Fine retrieved successfully');
    }

    public function update(UpdateFineStatusRequest $request, Fine $fine)
    {
        $data = $request->validated();
        if ($data['payment_status'] === 'paid') {
            $data['payment_date'] = now();
            if (empty($data['payment_method'])) {
                $data['payment_method'] = 'Cash';
            }
        } else {
            $data['payment_date'] = null;
            $data['payment_method'] = null;
        }

        $fine->update($data);
        return $this->success(new FineResource($fine), 'Fine status updated successfully');
    }
}
