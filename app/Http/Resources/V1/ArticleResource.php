<?php

namespace App\Http\Resources\V1;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $includeUsers = $request->query('includeUsers');

        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'createdBy' => $includeUsers
                ? User::find($this->user_id, ['id', 'name'])
                : $this->user_id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
