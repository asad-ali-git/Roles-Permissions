<?php

namespace App\Http\Resources;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    private array $statuses;

    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->statuses = Role::statuses();
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
            'status' => $this->statuses[$this->status],
            'created_at' => $this->created_at,
        ];
    }
}
