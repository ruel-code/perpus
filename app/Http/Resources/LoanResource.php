<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'loan_code' => $this->loan_code,
            'user' => $this->whenLoaded('user'),
            'book' => new BookResource($this->whenLoaded('book')),
            'loan_date' => $this->loan_date?->format('Y-m-d'),
            'return_date' => $this->return_date?->format('Y-m-d'),
            'actual_return_date' => $this->actual_return_date?->format('Y-m-d'),
            'status' => $this->status,
            'processed_by' => $this->processed_by,
            'processed_by_user' => $this->whenLoaded('processedBy'),
            'condition_notes' => $this->condition_notes,
            'fine' => new FineResource($this->whenLoaded('fine')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
