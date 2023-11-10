<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FavoriteRestaurant;
use App\Models\Restaurant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RestaurantController extends Controller
{
    public function listRestaurantsByText(Request $request){
        try {

            // Define rules to validations
            $rules = [
                'text' => ['required', 'string', 'max:30'],
            ];

            // Define validation messages
            $messages = [
                'text.required' => 'El texto es requerido.',
                'text.string' => 'El texto solo debe contener letras y números.',
                'text.max' => 'El texto debe ser máximo de 30 caracteres.',
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


            // Find restaurant
            $data = Restaurant::where('name', 'LIKE', '%'.$request->text.'%')
                    ->orWhere('description', 'LIKE', '%'.$request->text.'%')
                    ->get();


            // No restaurant found
            if(count($data) <= 0){
                return response()->json([
                    "status" => "failed",
                    "data" => null,
                    "message" => "No se encontraron restaurantes."
                ], 401);
            }


            // Add 'data:image/png;base64,' prefix to images
            $data = collect($data)->map(function ($item) {
                $item['image'] = 'data:image/png;base64,' . $item['image'];
                return $item;
            })->all();


            // Return successful response with the searched restaurant
            return response()->json([
                "status" => "success",
                "data" => $data,
                "message" => "Los restaurantes se han obtenido correctamente."
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

    public function listRestaurantsOrderedByDateAsc(){
        try {

            // Find restaurant
            $data = Restaurant::orderBy('updated_at', 'ASC')
                    ->get();


            // No restaurant found
            if(count($data) <= 0){
                return response()->json([
                    "status" => "failed",
                    "data" => null,
                    "message" => "No se encontraron restaurantes."
                ], 401);
            }


            // Add 'data:image/png;base64,' prefix to images
            $data = collect($data)->map(function ($item) {
                $item['image'] = 'data:image/png;base64,' . $item['image'];
                return $item;
            })->all();

            
            // Return successful response with the searched restaurant
            return response()->json([
                "status" => "success",
                "data" => $data,
                "message" => "El restaurante se ha obtenido correctamente."
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

    public function listRestaurantsOrderedByDateDesc(){
        try {

            // Find restaurant
            $data = Restaurant::orderBy('updated_at', 'DESC')
                    ->get();


            // No restaurant found
            if(count($data) <= 0){
                return response()->json([
                    "status" => "failed",
                    "data" => null,
                    "message" => "No se encontraron restaurantes."
                ], 401);
            }


            // Add 'data:image/png;base64,' prefix to images
            $data = collect($data)->map(function ($item) {
                $item['image'] = 'data:image/png;base64,' . $item['image'];
                return $item;
            })->all();

            
            // Return successful response with the searched restaurant
            return response()->json([
                "status" => "success",
                "data" => $data,
                "message" => "Los restaurante se ha obtenido correctamente."
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

    public function listRestaurantsOrderedByIdAsc(){
        try {

            // Find Restaurant
            $data = Restaurant::orderBy('id', 'ASC')
                    ->get();


            // No Restaurant found
            if(count($data) <= 0){
                return response()->json([
                    "status" => "failed",
                    "data" => null,
                    "message" => "No se encontraron restaurantes."
                ], 401);
            }


            // Add 'data:image/png;base64,' prefix to images
            $data = collect($data)->map(function ($item) {
                $item['image'] = 'data:image/png;base64,' . $item['image'];
                return $item;
            })->all();

            
            // Return successful response with the searched Restaurant
            return response()->json([
                "status" => "success",
                "data" => $data,
                "message" => "Los restaurantes se han obtenido correctamente."
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

    public function listRestaurantsOrderedByIdDesc(){
        try {

            // Find Restaurants
            $data = Restaurant::orderBy('id', 'DESC')
                    ->get();


            // No restaurante found
            if(count($data) <= 0){
                return response()->json([
                    "status" => "failed",
                    "data" => null,
                    "message" => "No se encontraron restaurantes."
                ], 401);
            }


            // Add 'data:image/png;base64,' prefix to images
            $data = collect($data)->map(function ($item) {
                $item['image'] = 'data:image/png;base64,' . $item['image'];
                return $item;
            })->all();

            
            // Return successful response with the searched restaurante
            return response()->json([
                "status" => "success",
                "data" => $data,
                "message" => "Los restaurantes se ha obtenido correctamente."
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

    public function RestaurantDetails($id, $userId) {
        try {

            // Find Restaurante
            $data = Restaurant::findOrFail($id);
            $data->loadCount('favoriteRestaurants');
            $favorite = FavoriteRestaurant::where('user_id', $userId)
                             ->where('restaurant_id', $id)
                             ->exists();
            $data->is_favorite = $favorite;

            // Add 'data:image/png;base64,' prefix to images
            $data->image = 'data:image/png;base64,' .  $data->image;

            // Return successful response with the found concert
            return response()->json([
                "status" => "success",
                "data" => $data,
                "message" => "El Restaurante se ha obtenido correctamente."
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

    public function popularRestaurants() {
        try {
            
            $resultCount = 10;

            // Find all restaurantes on favorites
            $data = Restaurant::withCount('favoriteRestaurants')
            ->orderBy('favorite_restaurants_count', 'desc')
            ->take($resultCount)
            ->get();

            // Add 'data:image/png;base64,' prefix to images
            $data = collect($data)->map(function ($item) {
                $item['image'] = 'data:image/png;base64,' . $item['image'];
                return $item;
            })->all();

            // Return successful response with the popular restaurantes
            return response()->json([
                "status" => "success",
                "data" => $data,
                "message" => "Los restaurantes se han obtenido correctamente."
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
