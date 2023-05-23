<?php

namespace App\Http\Requests\Analitics;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $spec_pos
 * @property array $exp
 * @property \DateTime $date_start
 * @property \DateTime $date_end
 */
class GetAllDataForChartsRequest extends FormRequest
{
    /**
     * @return \string[][]
     */
    public function rules(): array
    {
        return [
            'spec_pos'   => ['required'],
            'exp'        => ['required', 'array'],
            'date_start' => ['required'],
            'date_end'   => ['required'],
        ];
    }
}
