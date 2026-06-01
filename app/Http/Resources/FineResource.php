<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FineResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'loan_id' => $this->loan_id,
            'user_id' => $this->user_id,
            'user' => $this->whenLoaded('user'),
            'loan' => $this->whenLoaded('loan'),
            'category' => $this->category,
            'amount' => $this->amount,
            'days_late' => $this->days_late,
            'payment_status' => $this->payment_status,
            'payment_method' => $this->payment_method,
            'payment_date' => $this->payment_date?->format('Y-m-d'),
            'created_at' => $this->created_at,
        ];
    }
}
