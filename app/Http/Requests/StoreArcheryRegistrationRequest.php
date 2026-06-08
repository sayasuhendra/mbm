<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreArcheryRegistrationRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'parent_name' => ['required', 'string', 'max:255'],
            'parent_whatsapp' => ['required', 'string', 'max:30'],
            'parent_address' => ['required', 'string', 'max:2000'],
            'child_name' => ['required', 'string', 'max:255'],
            'child_age' => ['required', 'integer', 'min:5', 'max:18'],
            'child_school_class' => ['required', 'string', 'max:255'],
            'training_permission' => ['required', 'boolean'],
            'weekly_donation_choice' => ['required', 'in:5000,10000,15000,other'],
            'weekly_donation_other' => ['nullable', 'required_if:weekly_donation_choice,other', 'integer', 'min:1000', 'max:1000000'],
            'equipment_option' => ['required', 'in:self_purchase_full,self_purchase_arrows,provided_by_committee,shared_contribution'],
            'equipment_contribution_amount' => ['nullable', 'required_if:equipment_option,shared_contribution', 'integer', 'min:1000', 'max:5000000'],
            'suggestion' => ['nullable', 'string', 'max:5000'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function registrationData(): array
    {
        $validated = $this->validated();
        $validated['weekly_donation_amount'] = $validated['weekly_donation_choice'] === 'other'
            ? (int) $validated['weekly_donation_other']
            : (int) $validated['weekly_donation_choice'];

        unset($validated['weekly_donation_choice'], $validated['weekly_donation_other']);

        return $validated;
    }
}
