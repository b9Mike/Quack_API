<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FavoriteRestaurant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FavoriteRestaurantController extends Controller
{
    public function userFavoriteRestaurants($id){
        try {

            // List all user's favorite videogames
            $data = FavoriteRestaurant::whereHas('user', function($q) use($id){
                $q->where('id', '=', $id);
            })
            ->with(['restaurant'])
            ->get();

            if(count($data) <= 0){

                // Return failed response
                return response()->json([
                    "status" => "failed",
                    "data" => null,
                    "message" => [
                        "message" => ["El usuario no cuenta con restaurantes favoritos."]
                    ],
                ]);
            }


            // Add 'data:image/png;base64,' prefix to image
            $data = $data->map(function($item) {
                $item->restaurant->image = collect($item->restaurant->image)->map(function($image) {
                    return 'data:image/png;base64,' . $image;
                })->all();
                return $item;
            });


            // Return successful response with the user favorite videogames
            return response()->json([
                "status" => "success",
                "data" => $data,
                "message" => [
                    "message" => ["Los restaurantes favoritos del usuario se han obtenido correctamente."]
                ],
            ]);

        }
        catch(Exception $exception) {

            return response()->json([
                "status" => "error",
                "data" => null,
                "message" => [
                    "error" => [$exception->getMessage()]
                ],
            ], 500);
        }
    }

    public function store(Request $request){
        
        try {

            // Define rules to validations
            $rules = [
                'user_id' => ['required', 'numeric', 'exists:users,id'],
                'restaurant_id' => ['required', 'numeric', 'exists:restaurants,id']
            ];

            // Define validation messages
            $messages = [
                'user_id.required' => 'El ID del usuario es requerido.',
                'user_id.numeric' => 'El ID del usuario solo debe contener números.',
                'user_id.exists' => 'El ID del usuario no existe.',

                'restaurant_id.required' => 'El ID del restaurante es requerido.',
                'restaurant_id.numeric' => 'El ID del restaurante solo debe contener números.',
                'restaurant_id.exists' => 'El ID del restaurante no existe.',
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
                ], 401);

            }


            // Check if FavoriteVideogame already exists
            $favoriteVideogame = FavoriteRestaurant::where('user_id', $request->user_id)
                                 ->where('restaurant_id', $request->restaurant_id)
                                 ->first();

            if (isset($favoriteVideogame)) {

                // Return response with validation messages
                return response()->json([
                    "status" => "failed",
                    "data" => null,
                    "message" => [
                        "message" => ["El restaurante ya ha sido agregado a favoritos para este usuario."]
                    ],
                ], 401);

            }


            // Add Favorite Videogame
            $data = new FavoriteRestaurant();
            $data->user_id = $request->user_id;
            $data->restaurant_id = $request->restaurant_id;
            $data->save();


            // Return successful response with added videogame to favorites
            return response()->json([
                "status" => "success",
                "data" => null,
                "message" => [
                    "message" => ["Se ha agregado el restaurante a favoritos correctamente."]
                ],
            ]);

        }
        catch(Exception $exception) {

            return response()->json([
                "status" => "error",
                "data" => null,
                "message" => [
                    "error" => [$exception->getMessage()]
                ]
            ], 500);
        }
    }

    public function delete($restaurant_id, $user_id){

        try {
            
            // Define rules to validations
            $rules = [
                'user_id' => ['required', 'numeric', 'exists:users,id'],
                'restaurant_id' => ['required', 'numeric', 'exists:restaurants,id']
            ];

            // Define validation messages
            $messages = [
                'user_id.required' => 'El ID del usuario es requerido.',
                'user_id.numeric' => 'El ID del usuario solo debe contener números.',
                'user_id.exists' => 'El ID del usuario no existe.',

                'restaurant_id.required' => 'El ID del videojuego es requerido.',
                'restaurant_id.numeric' => 'El ID del videojuego solo debe contener números.',
                'restaurant_id.exists' => 'El ID del videojuego no existe.',
            ];

            // Instance validator
            $validator = Validator::make(['user_id' => $user_id, 'restaurant_id' => $restaurant_id], $rules, $messages);

            // Check if request has validation messages
            if ($validator->fails()) {

                // Return response with validation messages
                return response()->json([
                    "status" => "failed",
                    "data" => null,
                    "message" => $validator->messages()
                ], 401);
            }


            // Find FavoriteVideogame
            $data = FavoriteRestaurant::where('user_id', $user_id)
                    ->where('restaurant_id', $restaurant_id)
                    ->first();


            // If FavoriteRestaurant record doesn't exist, send failed response
            if(!isset($data)){

                return response()->json([
                    "status" => "failed",
                    "data" => null,
                    "message" => [
                        "error" => ["El usuario no tiene este restaurante en favoritos."]
                    ]
                ], 401);

            }

            // Delete Favorite restaurante
            $data->delete();

            // Return successful response with the updated review
            return response()->json([
                "status" => "success",
                "data" => null,
                "message" => [
                    "message" => ["Se ha eliminado el restaurante de favoritos correctamente."]
                ]
            ]);


        } catch(Exception $exception) {

            return response()->json([
                "status" => "error",
                "data" => null,
                "message" => [
                    "message" => [$exception->getMessage()]
                ]
            ], 500);
        }
    }
}
