<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditMaisonRequest extends FormRequest
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
            'annee_construction'=> 'required|date',
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
            'image.required' => 'l\'image doit être fourni',
            'image.image' => 'Seul les images sont autorisés',
            'image.max' => 'La taille de l\'image est trop grand 50 mo max',
            'image.mimes' => "L'image est invalide",
            'annee_construction.required'=> "l'annee de construction est requis",
            'annee_construction.date'=> "le format de date de construction est incorrect",
            'description.required'=> "la description est requis",
        ];
    }
}
