<?php

namespace App\Http\Requests\Backend\Variable;

use App\Models\Variable;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class VariableValueUpdateRequest
 * @package App\Http\Requests\Variable
 */
class VariableValueUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        $type = app(Variable::class)->getTypeKeyById($this->request->get('type', 1));
        $multilingual = $this->request->get('multilingual', false);

        if ($multilingual) {
            foreach (config('app.locales') as $locale) {
                $rules[$locale.'.text'] = 'nullable|string';
            }
        } else {
            if ($type == 'multi_select') {
                $rules['value'] = 'nullable|array';
            } elseif ($type == 'range') {
                $rules['value.from'] = 'nullable|present|numeric';
                $rules['value.to'] = 'nullable|present|numeric';
            } elseif ($type == 'img_button') {
                //$regex = '/^.*\.('.implode('|', config('image.allowed_image_extension')).')$/';

                $rules['value.image'] = 'required|string';
                $rules['value.url'] = 'nullable|string';
            } else {
                $rules['value'] = 'nullable|string';
            }
        }

        if ($type == 'image') {
            $regex = '/^.*\.('.implode('|', config('image.allowed_image_extension')).')$/';

            $rules = [
                'value' => 'required|regex:'.$regex,
            ];
        }

        $rules['status'] = 'required|boolean';
        $rules['variable_id'] = 'required|exists:variables,id';

        return $rules;
    }
}
