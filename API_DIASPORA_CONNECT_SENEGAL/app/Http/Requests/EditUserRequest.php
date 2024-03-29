<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditUserRequest extends FormRequest
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
            'nom'=>'required',
            'prenom'=>'required',
            'image'=>'sometimes',
            // 'email'=>'unique:users,email|email',
            'email'=>'required|email',
            // 'password'=>'required|regex:/^(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[@#$%^&+=!])(.{8,})$/',
            'telephone' =>'required|regex:/^7[0-9]{8}$/',
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
            'nom.required'=>'le nom est requis',
            'prenom.required'=>'le prenom est requis',
            'image.required'=>'l\'image est requis',
            'email.required'=>'l\'email est requis',
            // 'email.unique'=>'l\'email existe déja',
            'email.email'=> 'format email est incorrect',
            'telephone.required'=>'le numéro de téléphone est requis',
            'telephone.unique'=>'le numéro telephone est deja utilisé',
            'telephone.regex'=>'le format du numéro est incorrect',
        ];
    }
}
