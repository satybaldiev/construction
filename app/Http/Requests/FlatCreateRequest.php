<?php

namespace App\Http\Requests;

use App\Enum\FlatType;
use Illuminate\Foundation\Http\FormRequest;

class FlatCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required',
            'area'        => 'required|numeric',
            'room_count'  => 'required',
            'type'        => 'required|in:' . implode(',', FlatType::getAllValues()),
            'section'     => 'required',
            'floor'       => 'required',
            'notes'       => 'nullable|string',
            'plan_id'     => 'nullable|integer|exists:plans,id',
        ];
    }
}
