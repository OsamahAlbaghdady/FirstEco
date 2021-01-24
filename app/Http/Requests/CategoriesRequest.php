<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoriesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $req = [];
        foreach (config('translatable.locales') as $locale) {
            if (empty($this->$locale['id'])) {
                $req += [$locale . '.name' => 'required|unique:category_translations,name,'];
            } else {
                $req += [$locale . '.name' => 'required|unique:category_translations,name,' . $this->$locale['id']];
            }
        }

        return $req;
    }
}
