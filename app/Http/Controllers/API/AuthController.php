<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Rules\ImageSize;
use App\Rules\Lowercase;
use App\Rules\Number;
use App\Rules\Uppercase;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    
    public function login(Request $request){
        try {

            // Define rules to validations
            $rules = [
                'email' => ['required', 'email'],
                'password' => ['required', 'string']
            ];

            $messages = [
                'email.required' => 'El correo electrónico es requerido.',
                'email.email' => 'El correo electrónico no es válido.',

                'password.required' => 'La contraseña es requerida.',
                'password.string' => 'La contraseña ingresada no es válida.'
            ];

            // Instance validator
            $validator = Validator::make($request->all(), $rules, $messages);

            // Check if request has validation messages
            if ($validator->fails()) {

                // Return response with validation messages
                return response()->json([
                    "status" => "failed",
                    "data" => null,
                    "message" => $validator->messages()
                ], 422);

            } 

            // Check if credentials match with our records
                if(!Auth::attempt($request->only(['email', 'password']))){
                    return response()->json([
                        "status" => "failed",
                        "data" => null,
                        "message" => [
                            "email" => ["Las credenciales no coinciden con nuestros registros."]
                        ],
                    ], 401);
                }

            // Find user
            $data = User::where('email', $request->email)
            ->first();

            // Check if user is an AppUser
            if(!$data->hasRole('AppUser')) {
                return response()->json([
                    "status" => "failed",
                    "data" => null,
                    "message" => [
                        "email" => ["Las credenciales no coinciden con nuestros registros."]
                    ],
                ], 401);
            }

            // Delete access tokens
            // DB::table('personal_access_tokens')
            // ->where('tokenable_type', 'App\Models\User')
            // ->where('tokenable_id', $data->id)
            // ->delete();

            // Add 'data:image/png;base64,' prefix to image
            if(isset($data->image)){
                $data->image = 'data:image/png;base64,' . $data->image;
            }

            // Return successful response with the logged user
            return response()->json([
                "status" => "success",
                "data" => $data,
                // "access_token" => $data->createToken("auth_token")->plainTextToken,
                "message" => [
                    "email" => ["Acceso obtenido."]
                ],
            ]);

        }
        catch(Exception $exception) {

            return response()->json([
                "status" => "error",
                "data" => null,
                "message" => $exception->getMessage()
            ], 500);
        }
    }

    public function register(Request $request) {

        try {

            // Define validation rules
            $rules = [
                'nickname' => ['required', 'string', 'unique:users,nickname'],
                'description' => ['nullable', 'string', 'max:200'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8', 'confirmed', new Uppercase, new Lowercase, new Number],
                'password_confirmation' => ['required', 'string'],
                'name' => ['required', 'string', 'max:25'],
                'last_name' => ['required', 'string', 'max:40'],
                'address' => ['nullable', 'string', 'max:250'],
                'phone' => ['nullable', 'numeric', 'digits:10'],
                'image' => ['required', new ImageSize], // 'image', 'mimes:jpg,jpeg,png'
            ];

            // Define validation messages
            $messages = [
                'nickname.required' => 'El alias es requerido.',
                'nickname.string' => 'El alias solo debe contener letras y números.',
                'nickname.unique' => 'Este alias ya ha sido registrado.',
                
                'description.string' => 'La descripción solo debe contener letras y números.',
                'description.max' => 'La descripción debe ser máximo de 200 caracteres.',

                'email.required' => 'El correo electrónico es requerido.',
                'email.email' => 'El correo electrónico no es válido.',
                'email.unique' => 'Este correo electrónico ya ha sido registrado.',

                'password.required' => 'La contraseña es requerida.',
                'password.string' => 'La contraseña solo debe contener letras y números.',
                'password.min' => 'La contraseña debe tener mínimo 8 caracteres.',
                'password.confirmed' => 'La confirmación de la contraseña no coincide.',

                'password_confirmation.required' => 'La confirmación de la contraseña es requerida.',
                'password_confirmation.string' => 'La confirmación solo debe contener letras y números.',

                'name.required' => 'El nombre es requerido.',
                'name.string' => 'El nombre solo debe contener letras y números.',
                'name.max' => 'El nombre debe ser máximo de 25 caracteres.',

                'last_name.required' => 'El apellido es requerido.',
                'last_name.string' => 'El apellido solo debe contener letras y números.',
                'last_name.max' => 'El apellido debe ser máximo de 40 caracteres.',

                'address.string' => 'El apellido solo debe contener letras y números.',
                'address.max' => 'La ciudad debe ser máximo de 40 caracteres.',

                'phone.numeric' => 'El teléfono solo debe ser contener números.',
                'phone.digits' => 'El teléfono debe contener 10 dígitos.',

                'image.required' => 'La imagen de perfil es requerida.',

                // 'image.image' => 'La imagen debe ser de tipo imagen.',
                // 'image.mimes' => 'La imagen debe estar en formato: jpg, jpeg o png.',
            ];

            // Instance validator
            $validator = Validator::make($request->all(), $rules, $messages);

            // Check if request has validation messages
            if ($validator->fails()) {

                // Return response with validation messages
                return response()->json([
                    "status" => "failed",
                    "data" => null,
                    "message" => $validator->messages()
                ], 422);

            } 


            // Create user
            $data = new User();
            $data->fill($request->all());
            $data->password = Hash::make($request->password);
            // if(isset($request->image)){
            //     // Verificar si la cadena está en formato UTF-8
            //     if (!mb_check_encoding($request->image, 'UTF-8')) {
            //         // Convertir la cadena base64 a formato UTF-8
            //         $imagen_codificada_utf8 = mb_convert_encoding($request->image, 'UTF-8');   
            //         // Decodificar la imagen
            //         $data->image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imagen_codificada_utf8)); 
            //     }
            // }
            if(isset($request->image)){
                $data->image = substr($request->image, strpos($request->image, ',') + 1);
            }
            $data->save();

            // Asign AppUser Role
            $data->assignRole('AppUser');


            // Add 'data:image/png;base64,' prefix to image
            if(isset($data->image)){
                $data->image = 'data:image/png;base64,' . $data->image;
            }


            // Return successful response with the created user
            return response()->json([
                "status" => "success",
                "data" => $data,
                // "access_token" => $data->createToken("auth_token")->plainTextToken,
                "message" => [
                    "email" => ["Usuario registrado correctamente."]
                ],
            ]);

        }
        catch(Exception $exception) {

            return response()->json([
                "status" => "error",
                "data" => null,
                "message" => $exception->getMessage()
            ], 500);
        }

    }

    public function logout(Request $request){

        try {
            // Obtener el usuario autenticado
            $user = $request->user();
    
            // Si está autenticado, eliminar el token de acceso

            /* if ($user) {
                
                $user->currentAccessToken()->delete();

            } else {

                // Si no está autenticado, regresar respuesta fallida
                return response()->json([
                    "status" => "failed",
                    "data" => 'null',
                    "message" => [
                        "error" => ["El usuario no está autenticado."]
                    ],
                ], 401);
            } */
        
            return response()->json([
                "status" => "success",
                "data" => 'null',
                "message" => [
                    "message" => ["Sesión cerrada correctamente."]
                ],
            ]);

        } catch(Exception $exception) {

            return response()->json([
                "status" => "error",
                "data" => null,
                "message" => [
                    "error" => [$exception->getMessage()]
                ]
            ], 500);
        }
    }
}
