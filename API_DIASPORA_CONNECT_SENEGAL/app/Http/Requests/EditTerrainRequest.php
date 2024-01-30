<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditTerrainRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'addresse'=> 'required',
            'superficie'=> 'required|integer',
            'prix'=> 'required|integer',
            'description'=> 'required',
            'image' => 'sometimes',
            // 'type_terrain'=> 'required',
        ];
    }

    public function failedValidation(Validator $validator ){
        throw new HttpResponseException(response()->json([
            'success'=>false,
            'status_code'=>422,
            'error'=>true,
            'message'=>'erreur de validation',
            'errorList'=>$validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            'addresse.required'=> "addresse ne peut pas être null",
            'superficie.required'=> "la superficie est requis",
            'superficie.number'=> "le format de la superficie est incorrect",
            'prix.required'=> "le prix est requis",
            'image.sometimes' => 'l\'image doit être fourni',
            'image.image' => 'Seul les images sont autorisés',
            // 'type_terrain.required'=> "le type de terrain est requis",
            'description.required'=> "la description est requis",
        ];
    }
}
