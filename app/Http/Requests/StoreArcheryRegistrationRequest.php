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
        if ($this->isCompetitionRegistration()) {
            return [
                'name' => ['required', 'string', 'max:255'],
                'whatsapp' => ['required', 'string', 'max:30'],
                'rt' => ['required', 'string', 'max:20'],
                'competition_category' => ['required', 'in:kelas_3_6_pria,kelas_3_6_wanita,remaja,dewasa_pria'],
                'suggestion' => ['nullable', 'string', 'max:5000'],
            ];
        }

        return [
            'parent_name' => ['required', 'string', 'max:255'],
            'parent_whatsapp' => ['required', 'string', 'max:30'],
            'parent_address' => ['required', 'string', 'max:2000'],
            'child_name' => ['required', 'string', 'max:255'],
            'child_age' => ['required', 'integer'],
            'child_school_class' => ['required', 'string', 'max:255'],
            'training_permission' => ['required', 'boolean'],
            'weekly_donation_choice' => ['required', 'in:5000,10000,15000,other'],
            'weekly_donation_other' => ['nullable', 'required_if:weekly_donation_choice,other', 'integer', 'min:1000', 'max:1000000'],
            'equipment_option' => ['required', 'in:self_purchase_full,self_purchase_arrows,provided_by_committee,shared_contribution'],
            'suggestion' => ['nullable', 'string', 'max:5000'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function registrationData(): array
    {
        $validated = $this->validated();

        if ($this->isCompetitionRegistration()) {
            $category = $this->categoryLabel($validated['competition_category']);

            return [
                'parent_name' => $validated['name'],
                'parent_whatsapp' => $validated['whatsapp'],
                'parent_address' => 'RT '.$validated['rt'],
                'rt' => $validated['rt'],
                'child_name' => $validated['name'],
                'child_age' => 0,
                'child_school_class' => $category,
                'competition_category' => $validated['competition_category'],
                'event_name' => 'Lomba Panahan 17 Agustus 2026',
                'training_permission' => true,
                'weekly_donation_amount' => 0,
                'equipment_option' => 'provided_by_committee',
                'suggestion' => $validated['suggestion'] ?? null,
            ];
        }

        $validated['weekly_donation_amount'] = $validated['weekly_donation_choice'] === 'other'
            ? (int) $validated['weekly_donation_other']
            : (int) $validated['weekly_donation_choice'];

        unset($validated['weekly_donation_choice'], $validated['weekly_donation_other']);

        return $validated;
    }

    private function isCompetitionRegistration(): bool
    {
        return $this->hasAny(['name', 'whatsapp', 'rt', 'competition_category'])
            || $this->routeIs('archery.competition.*');
    }

    private function categoryLabel(string $category): string
    {
        return match ($category) {
            'kelas_3_6_pria' => 'Kelas 3-6 Pria',
            'kelas_3_6_wanita' => 'Kelas 3-6 Wanita',
            'remaja' => 'Remaja',
            'dewasa_pria' => 'Dewasa Pria',
        };
    }
}
