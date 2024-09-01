<?php

namespace App\Http\Requests\Api\V1;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TaskStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => [
                'required',
                'uuid',
                Rule::unique(Task::class),
            ],
            'title' => [
                'required',
            ],
            'description' => [
                'nullable',
            ],
            'status' => [
                'nullable',
                Rule::enum(TaskStatusEnum::class),
            ]
        ];
    }
}
