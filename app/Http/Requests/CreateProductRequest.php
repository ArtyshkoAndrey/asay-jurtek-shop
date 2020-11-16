<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
    return [
      'title'       => 'required|string|max:255',
      'description' => 'required',
      'price'       => 'required|integer|min:0',
      'price_sale'  => 'sometimes|integer|min:0|nullable',
      'weight'      => 'required|min:0',
      'on_new'      => 'i',
      'on_sale'     => 'boolean',
      'meta'        => 'required|array',
      'sex'         => 'required|string',
      'status'      => 'required|string',
      'category'    => 'required|exists:App\Models\Category,id',
      'skus'        => 'required|exists:App\Models\Skus,id'
    ];
  }
}
