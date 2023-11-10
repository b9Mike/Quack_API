<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FavoriteReview;
use Exception;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FavoriteReviewController extends Controller
{
    public function userFavoriteReviews($id){
        try {

            // List all user's favorite reviews
            $data = FavoriteReview::whereHas('user', function($q) use($id){
                $q->where('id', '=', $id);
            })
            ->with(['review.user', 'review.restaurant', 'review.images'])
            ->get();

            if(count($data) <= 0){

                // Return failed response
                return response()->json([
                    "status" => "failed",
                    "data" => null,
                    "message" => "El usuario no cuenta con reviews favoritas."
                ]);
            }


            // Add 'data:image/png;base64,' prefix to review images
            $data = collect($data)->map(function ($item) {
                $item->review->restaurant->image = 'data:image/png;base64,' . $item->review->restaurant->image;
                $item->review->user->image = 'data:image/png;base64,' . $item->review->user->image;
                $item->review->images = collect($item->review->images)->map(function ($image) {
                    $image->image = 'data:image/png;base64,' . $image->image;
                    return $image;
                });
                return $item;
            });


            // Return successful response with the user favorite reviews
            return response()->json([
                "status" => "success",
                "data" => $data,
                "message" => "Las reviews favoritas del usuario se han obtenido correctamente."
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

    public function store(Request $request){
        
        try {

            // Define rules to validations
            $rules = [
                'user_id' => ['required', 'numeric', 'exists:users,id'],
                'review_id' => ['required', 'numeric', 'exists:reviews,id']
            ];

            // Define validation messages
            $messages = [
                'user_id.required' => 'El ID del usuario es requerido.',
                'user_id.numeric' => 'El ID del usuario solo debe contener números.',
                'user_id.exists' => 'El ID del usuario no existe.',

                'review_id.required' => 'El ID de la review es requerido.',
                'review_id.numeric' => 'El ID de la review solo debe contener números.',
                'review_id.exists' => 'El ID de la review no existe.',
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


            // Check if FavoriteReview already exists
            $favoriteReview = FavoriteReview::where('user_id', $request->user_id)
                                 ->where('review_id', $request->restaurant_id)
                                 ->first();

            if (isset($favoriteReview)) {

                // Return response with validation messages
                return response()->json([
                    "status" => "failed",
                    "data" => null,
                    "message" => "La review ya ha sido agregada a favoritos para este usuario."
                ], 401);

            }


            // Add Favorite restaurant
            $data = new FavoriteReview();
            $data->user_id = $request->user_id;
            $data->review_id = $request->review_id;
            $data->save();


            // Return successful response with added review to favorites
            return response()->json([
                "status" => "success",
                "data" => null,
                "message" => "Se ha agregado la review a favoritos correctamente.",
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

    public function delete($review_id, $user_id){

        try {
            
            // Define rules to validations
            $rules = [
                'user_id' => ['required', 'numeric', 'exists:users,id'],
                'review_id' => ['required', 'numeric', 'exists:reviews,id']
            ];

            // Define validation messages
            $messages = [
                'user_id.required' => 'El ID del usuario es requerido.',
                'user_id.numeric' => 'El ID del usuario solo debe contener números.',
                'user_id.exists' => 'El ID del usuario no existe.',

                'review_id.required' => 'El ID de la review es requerido.',
                'review_id.numeric' => 'El ID de la review solo debe contener números.',
                'review_id.exists' => 'El ID de la review no existe.',
            ];

            // Instance validator
            $validator = Validator::make(['user_id' => $user_id, 'review_id' => $review_id], $rules, $messages);

            // Check if request has validation messages
            if ($validator->fails()) {

                // Return response with validation messages
                return response()->json([
                    "status" => "failed",
                    "data" => null,
                    "message" => $validator->messages()
                ], 401);
            }


            // Find FavoriteReview
            $data = FavoriteReview::where('user_id', $user_id)
                    ->where('review_id', $review_id)
                    ->first();


            // If FavoriteReview record doesn't exist, send failed response
            if(!isset($data)){

                return response()->json([
                    "status" => "failed",
                    "data" => null,
                    "message" => "El usuario no tiene esta review en favoritos."
                ], 401);

            }

            // Delete Favorite Review
            $data->delete();

            // Return successful response with the updated review
            return response()->json([
                "status" => "success",
                "data" => null,
                "message" => "Se ha eliminado la review de favoritos correctamente."
            ]);


        } catch(Exception $exception) {

            return response()->json([
                "status" => "error",
                "data" => null,
                "message" => $exception->getMessage()
            ], 500);
        }
    }
}
