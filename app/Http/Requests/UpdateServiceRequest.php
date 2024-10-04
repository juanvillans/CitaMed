<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
        
            // 'user_id' => ['required',],
            // 'specialty_id' => ['required',],
            // 'title' => ['required',],
            // 'description' => ['required',],
            // 'duration_per_appointment' => ['required',],
            // 'schedule_json' => ['required',],
            // 'start_date_agenda' => ['required',],
            // 'end_date_agenda' => ['required',],
            // 'max_reservation_time_before_appointment' => ['required',],
            // 'min_reservation_time_before_appointment' => ['required',],
            // 'adjust_avability_json' => ['required',],
            // 'duration_between_appointment' => ['required',],
            // 'max_reservations_per_day' => ['required',],

        ];
    }
}
