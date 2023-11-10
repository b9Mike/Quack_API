<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\ImageSize;
use App\Rules\Lowercase;
use App\Rules\Number;
use App\Rules\Uppercase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function currentUser() {
        try {

            // Find user
            $data = auth()->user();

            // Add 'data:image/png;base64,' prefix to image
            //$data->image = 'data:image/png;base64,' . $data->image;

            // Return successful response with the created user
            return response()->json([
                "status" => "success",
                "data" => $data,
                "message" => [
                    "email" => ["El usuario se ha obtenido correctamente."]
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

    public function userDetails($id) {
        try {

            // Find user
            $data = User::findOrFail($id);

            // Add 'data:image/png;base64,' prefix to image
            $data->image = 'data:image/png;base64,' . $data->image;

            // Return successful response with the created user
            return response()->json([
                "status" => "success",
                "data" => $data,
                "message" => [
                    "email" => ["El usuario se ha obtenido correctamente."]
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

    public function profile($id) {

        try {

            // Find user
            $data = User::findOrFail($id);

            // Add 'data:image/png;base64,' prefix to image
            $data->image = 'data:image/png;base64,' . $data->image;

            // Return successful response with the created user
            return response()->json([
                "status" => "success",
                "data" => $data,
                "message" => [
                    "email" => ["El usuario se ha obtenido correctamente."]
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

    public function updateInformation(Request $request, $id) {
        
        try {

            // Define rules to validations
            $rules = [
                'nickname' => ['required', 'string', 'unique:users,nickname,'.$id],
                'description' => ['nullable', 'string', 'max:200'],
                'name' => ['required', 'string', 'max:25'],
                'last_name' => ['required', 'string', 'max:40'],
                'address' => ['nullable', 'string', 'max:250'],
                'phone' => ['nullable', 'numeric', 'digits:10'],
                'image' => ['required', new ImageSize], // 'image', 'mimes:jpg,jpeg,png'
            ];

            // Define validation messages
            $messages = [
                'nickname.required' => 'El alias es requerido.',
                'nickname.string' => 'El alias debe ser de tipo string.',
                'nickname.unique' => 'Este alias ya ha sido registrado.',

                'description.string' => 'La descripción solo debe contener letras y números.',
                'description.max' => 'La descripción debe ser máximo de 200 caracteres.',

                'name.required' => 'El nombre es requerido.',
                'name.string' => 'El nombre debe ser de tipo string.',
                'name.max' => 'El nombre debe ser máximo de 25 caracteres.',

                'last_name.required' => 'El apellido es requerido.',
                'last_name.string' => 'El apellido debe ser de tipo string.',
                'last_name.max' => 'El apellido debe ser máximo de 40 caracteres.',

                'address.string' => 'El apellido debe ser de tipo string.',
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


            // Find user
            $data = User::findOrFail($id);
            $data->nickname = $request->nickname;
           /*  $data->description = $request->description; */
            $data->name = $request->name;
            $data->last_name = $request->last_name;
            $data->address = $request->address;
            $data->phone = $request->phone;
            if(isset($request->image)){
                $data->image = substr($request->image, strpos($request->image, ',') + 1);
            }
            $data->save();

            // Return successful response with the created user
            return response()->json([
                "status" => "success",
                "data" => $data,
                "message" => [
                    "email" => ["Se ha actualizado el usuario correctamente."]
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

    public function updatePassword(Request $request, $id) {
        
        try {

            // Define rules to validations
            $rules = [
                'old_password' => ['required', 'string'],
                'new_password' => ['required', 'string', 'min:8', 'confirmed', new Uppercase, new Lowercase, new Number],
                'new_password_confirmation' => ['required', 'string'],
            ];

            // Define validation messages
            $messages = [
                'old_password.required' => 'La contraseña actual es requerida.',
                'old_password.string' => 'La contraseña actual solo debe contener letras y números.',

                'new_password.required' => 'La nueva contraseña es requerida.',
                'new_password.string' => 'La nueva contraseña debe ser de tipo string.',
                'new_password.min' => 'La nueva contraseña debe tener mínimo 8 caracteres.',
                'new_password.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
                'new_password.App\\Rules\\Uppercase' => 'La nueva contraseña debe tener al menos una mayúscula.',
                'new_password.App\\Rules\\Lowercase' => 'La nueva contraseña debe tener al menos una minúscula.',
                'new_password.App\\Rules\\Number' => 'La nueva contraseña debe tener al menos un número.',

                'new_password_confirmation.required' => 'La confirmación de la nueva contraseña es requerida.',
                'new_password_confirmation.string' => 'La confirmación de la nueva contraseña solo debe contener letras y números.',
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


            // Find user
            $data = User::findOrFail($id);


            // Check if old_password matches with the stored one.
            if (!$data || !Hash::check($request->old_password, $data->password)) {
                
                // old_password does not match
                return response()->json([
                    "status" => "failed",
                    "data" => null,
                    "message" => [
                        "old_password" => ["La contraseña actual no coincide con nuestros registros."]
                    ]
                ], 401);
            }


            // Save new hashed password
            $data->password = Hash::make($request->new_password);
            $data->save();


            // Add 'data:image/png;base64,' prefix to image
            $data->image = 'data:image/png;base64,' . $data->image;
            
            
            // Return successful response with the created user
            return response()->json([
                "status" => "success",
                "data" => $data,
                "message" => [
                    "email" => ["La contraseña del usuario ha sido actualizada correctamente."]
                ]
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

}
