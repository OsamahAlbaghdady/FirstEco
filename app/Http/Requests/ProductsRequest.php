<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
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
                $req += [$locale . '.name' => 'required|unique:product_translations,name,'];
                $req += [$locale . '.description' => 'required|unique:product_translations,description,'];
            } else {
                $req += [$locale . '.name' => 'required|unique:product_translations,name,' . $this->$locale['id']];
                $req += [$locale . '.description' => 'required|unique:product_translations,description,' . $this->$locale['id']];
            }
        }
         $req += [
            'category_id'=>'required',
            'purchase_price'=>'required',
            'sale_price'=>'required',
            'stock'=>'required',

         ];

        return $req;
    }
}
