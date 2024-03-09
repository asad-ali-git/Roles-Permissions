<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    private array $statuses;

    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->statuses = User::userStatuses();
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->statuses[$this->status],
            'created_at' => $this->created_at,
        ];
    }
}
