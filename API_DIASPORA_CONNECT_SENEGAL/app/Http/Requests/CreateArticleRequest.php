<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateArticleRequest extends FormRequest
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
            "titre"=> "required",
            "description"=> "required|string",
            "image"=> 'required|image|max:10000|mimes:jpeg,png,jpg',
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
            'description.required'=> "la description est requis",
            'description.string'=> "la description doit contenir que des lettres",
            'titre.required'=> "le titre est requis",
            'image.required' => 'l\'image doit être fourni',
            'image.image' => 'Seul les images sont autorisés',
            'image.max' => 'La taille de l\'image est trop grand 50 mo max',
            'image.mimes' => "L'image est invalide",
        ];
    }
}
