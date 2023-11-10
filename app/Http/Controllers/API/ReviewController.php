<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FavoriteReview;
use App\Models\Review;
use App\Models\ReviewImage;
use App\Rules\ImagesArraySize;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function listReviewsByText(Request $request){
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
                ], 422);

            } 


            // List all reviews
            $data = Review::with(['user', 'restaurant', 'images'])
                    ->orWhere('title', 'LIKE', '%'.$request->text.'%')
                    ->orWhere('description', 'LIKE', '%'.$request->text.'%')        
                    ->get();


            // Add 'data:image/png;base64,' prefix to user image(s)
            $data = $data->map(function ($review) {
                if (!empty($review->user->image) && strpos($review->user->image, 'data:image/png;base64,') === false) {
                    $review->user->image = 'data:image/png;base64,' . $review->user->image;
                }
                return $review;
            });
            

            // Add 'data:image/png;base64,' prefix to images
            $data = $data->map(function($review) {
                $review->images->map(function($image) {
                    $image->image = 'data:image/png;base64,' . $image->image;
                    return $image;
                });
                return $review;
            });


            // Add 'data:image/png;base64,' prefix to restaurant image
            $data = $data->map(function($item) {
                $item->restaurant->image = collect($item->restaurant->image)->map(function($image) {
                    return 'data:image/png;base64,' . $image;
                })->all();
                return $item;
            });
            

            // Return successful response with all listed reviews
            return response()->json([
                "status" => "success",
                "data" => $data,
                "message" => [
                    "title" => ["Las reviews se han obtenido correctamente."]
                ]
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

    public function listReviewsOrderedByDateAsc(){
        try {

            // List all reviews
            $data = Review::with(['user', 'restaurant', 'images'])
            ->orderBy('updated_at', 'ASC')     
            ->get();


            // Add 'data:image/png;base64,' prefix to user image(s)
            $data = $data->map(function ($review) {
                if (!empty($review->user->image) && strpos($review->user->image, 'data:image/png;base64,') === false) {
                    $review->user->image = 'data:image/png;base64,' . $review->user->image;
                }
                return $review;
            });


            // Add 'data:image/png;base64,' prefix to images
            $data = $data->map(function($review) {
                $review->images->map(function($image) {
                    $image->image = 'data:image/png;base64,' . $image->image;
                    return $image;
                });
                return $review;
            });


            // Add 'data:image/png;base64,' prefix to restaurant image
            $data = $data->map(function($item) {
                $item->restaurant->image = collect($item->restaurant->image)->map(function($image) {
                    return 'data:image/png;base64,' . $image;
                })->all();
                return $item;
            });


             // Return successful response with all listed reviews
            return response()->json([
                "status" => "success",
                "data" => $data,
                "message" => [
                    "title" => ["Las reviews se han obtenido correctamente."]
                ]
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

    public function listReviewsOrderedByDateDesc(){
        try {

            // List all reviews
            $data = Review::with(['user', 'restaurant', 'images'])
            ->orderBy('updated_at', 'DESC')     
            ->get();


            // Add 'data:image/png;base64,' prefix to user image(s)
            $data = $data->map(function ($review) {
                if (!empty($review->user->image) && strpos($review->user->image, 'data:image/png;base64,') === false) {
                    $review->user->image = 'data:image/png;base64,' . $review->user->image;
                }
                return $review;
            });


            // Add 'data:image/png;base64,' prefix to images
            $data = $data->map(function($review) {
                $review->images->map(function($image) {
                    $image->image = 'data:image/png;base64,' . $image->image;
                    return $image;
                });
                return $review;
            });


            // Add 'data:image/png;base64,' prefix to restaurant image
            $data = $data->map(function($item) {
                $item->restaurant->image = collect($item->restaurant->image)->map(function($image) {
                    return 'data:image/png;base64,' . $image;
                })->all();
                return $item;
            });


             // Return successful response with all listed reviews
            return response()->json([
                "status" => "success",
                "data" => $data,
                "message" => [
                    "title" => ["Las reviews se han obtenido correctamente."]
                ]
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

    public function listReviewsOrderedByIdAsc(){
        try {

            // List all reviews
            $data = Review::with(['user', 'restaurant', 'images'])
            ->orderBy('id', 'ASC')     
            ->get();


            // Add 'data:image/png;base64,' prefix to user image(s)
            $data = $data->map(function ($review) {
                if (!empty($review->user->image) && strpos($review->user->image, 'data:image/png;base64,') === false) {
                    $review->user->image = 'data:image/png;base64,' . $review->user->image;
                }
                return $review;
            });


            // Add 'data:image/png;base64,' prefix to images
            $data = $data->map(function($review) {
                $review->images->map(function($image) {
                    $image->image = 'data:image/png;base64,' . $image->image;
                    return $image;
                });
                return $review;
            });


            // Add 'data:image/png;base64,' prefix to restaurant image
            $data = $data->map(function($item) {
                $item->restaurant->image = collect($item->restaurant->image)->map(function($image) {
                    return 'data:image/png;base64,' . $image;
                })->all();
                return $item;
            });


            // Return successful response with all listed reviews
            return response()->json([
                "status" => "success",
                "data" => $data,
                "message" => [
                    "title" => ["Las reviews se han obtenido correctamente."]
                ]
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

    public function listReviewsOrderedByIdDesc(){
        try {

            // List all reviews
            $data = Review::with(['user', 'restaurant', 'images'])
            ->orderBy('id', 'DESC')     
            ->get();


            // Add 'data:image/png;base64,' prefix to user image(s)
            $data = $data->map(function ($review) {
                if (!empty($review->user->image) && strpos($review->user->image, 'data:image/png;base64,') === false) {
                    $review->user->image = 'data:image/png;base64,' . $review->user->image;
                }
                return $review;
            });


            // Add 'data:image/png;base64,' prefix to images
            $data = $data->map(function($review) {
                $review->images->map(function($image) {
                    $image->image = 'data:image/png;base64,' . $image->image;
                    return $image;
                });
                return $review;
            });


            // Add 'data:image/png;base64,' prefix to restaurant image
            $data = $data->map(function($item) {
                $item->restaurant->image = collect($item->restaurant->image)->map(function($image) {
                    return 'data:image/png;base64,' . $image;
                })->all();
                return $item;
            });


            // Return successful response with all listed reviews
            return response()->json([
                "status" => "success",
                "data" => $data,
                "message" => [
                    "title" => ["Las reviews se han obtenido correctamente."]
                ]
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

    public function userReviews($id) {
        try {

            // List all user reviews
            $data = Review::whereHas('user', function($q) use($id){
                $q->where('id', '=', $id);
            })
            ->with(['user', 'restaurant', 'images'])
            ->where('user_id', '=', $id)
            ->get();


            if(count($data) <= 0){

                // Return failed response because user doesn't have reviews yet. 
                return response()->json([
                    "status" => "failed",
                    "data" => $data,
                    "message" => [
                        "title" => ["El usuario no cuenta con reviews."]
                    ]
                ], 422);

            }


            // Add 'data:image/png;base64,' prefix to user image(s)
            $data = $data->map(function ($review) {
                if (!empty($review->user->image) && strpos($review->user->image, 'data:image/png;base64,') === false) {
                    $review->user->image = 'data:image/png;base64,' . $review->user->image;
                }
                return $review;
            });

            
            // Add 'data:image/png;base64,' prefix to images
            $data = $data->map(function($review) {
                $review->images->map(function($image) {
                    $image->image = 'data:image/png;base64,' . $image->image;
                    return $image;
                });
                return $review;
            });

            
            // Add 'data:image/png;base64,' prefix to restaurant image
            $data = $data->map(function($item) {
                $item->restaurant->image = collect($item->restaurant->image)->map(function($image) {
                    return 'data:image/png;base64,' . $image;
                })->all();
                return $item;
            });


            // Return successful response with all listed reviews
            return response()->json([
                "status" => "success",
                "data" => $data,
                "message" => [
                    "title" => ["Las reviews del usuario se han obtenido correctamente."]
                ]
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

    public function reviewDetails($id, $userId) {
        try {

            // Find restaurant
            $data = Review::with(['user', 'restaurant', 'images'])
                    ->where('id', $id)
                    ->firstOrFail();
            $data->loadCount('favoriteReviews');
            $favorite = FavoriteReview::where('user_id', $userId)
                             ->where('review_id', $id)
                             ->exists();
            $data->is_favorite = $favorite;
         

            if(!isset($data)){
                 // Return failed response because ID does not match. 
                 return response()->json([
                    "status" => "failed",
                    "data" => $data,
                    "message" => [
                        "title" => ["No existe una review con este ID."]
                    ]
                ], 422);
            }


            // Add 'data:image/png;base64,' prefix to user image(s)
            if (!empty($data->user->image) && strpos($data->user->image, 'data:image/png;base64,') === false) {
                $data->user->image = 'data:image/png;base64,' . $data->user->image;
            }

            // Add 'data:image/png;base64,' prefix to review images
            $data->images->map(function($image) {
                $image->image = 'data:image/png;base64,' . $image->image;
                return $image;
            });

            // Add 'data:image/png;base64,' prefix to restaurant image
            $data->restaurant->image = collect($data->restaurant->image)->map(function($image) {
                return 'data:image/png;base64,' . $image;
            })->all();
            

            // Return successful response with the found concert
            return response()->json([
                "status" => "success",
                "data" => $data,
                "message" => [
                    "title" => ["La review se ha obtenido correctamente."]
                ]
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

    
    public function store(Request $request){
        
        try {

            DB::beginTransaction();

            // Define rules to validations
            $rules = [
                'title' => ['required', 'string', 'max:100'],
                'description' => ['required', 'string'],
                'user_id' => ['required', 'numeric', 'exists:users,id'],
                'restaurant_id' => ['required', 'numeric', 'exists:restaurants,id'],
                'images' => ['required', 'array', new ImagesArraySize],
                'images.*' => 'filled'
            ];

            // Define validation messages
            $messages = [
                'title.required' => 'El título es requerido.',
                'title.string' => 'El título solo debe contener letras y números.',
                'title.max' => 'El título debe ser máximo de 100 caracteres.',
                
                'description.required' => 'La descripción es requerida.',
                'description.string' => 'La descripción solo debe contener letras y números.',

                'user_id.required' => 'El ID del usuario es requerido.',
                'user_id.numeric' => 'El ID del usuario solo debe contener números',
                'user_id.exists' => 'El ID del usuario no existe.',

                'restaurant_id.required' => 'El ID del restaurante es requerido.',
                'restaurant_id.numeric' => 'El ID del restaurante solo debe contener números',
                'restaurant_id.exists' => 'El ID del restaurante no existe.',

                'images.required' => 'Al menos una imagen es requerida.',
                'images.array' => 'Las imágenes deben ser enviadas en un array.',
                'images.*.filled' => 'Cada elemento del arreglo de imágenes debe estar lleno.'
            ];

            // Instance validator
            $validator = Validator::make($request->all(), $rules, $messages);

            // Check if request has validation messages
            if ($validator->fails()) {

                DB::rollBack();

                // Return response with validation messages
                return response()->json([
                    "status" => "failed",
                    "data" => null,
                    "message" => $validator->messages()
                ], 422);

            } 


            // Create Review
            $review = new Review();
            $review->fill($request->all());
            $review->updated_at = now();
            $review->save();


            // Store images
            foreach($request->images as $requestImage){

                $imageData = substr($requestImage, strpos($requestImage, ',') + 1);

                $reviewImage = new ReviewImage();
                $reviewImage->image = $imageData;
                $reviewImage->review_id = $review->id;
                $reviewImage->save();
            }

            DB::commit();

            // Return successful response with the created review
            return response()->json([
                "status" => "success",
                "data" => $review,
                "message" => [
                    "title" => ["Se ha creado la review correctamente."]
                ]
            ]);

        }
        catch(Exception $exception) {

            DB::rollBack();

            return response()->json([
                "status" => "error",
                "data" => null,
                "message" => [
                    "error" => [$exception->getMessage()]
                ]
            ], 500);
        }
    }

    public function update(Request $request, $id){

        try {

            DB::beginTransaction();
            
            // Define rules to validations
            $rules = [
                'title' => ['required', 'string', 'max:100'],
                'description' => ['required', 'string'],
                'user_id' => ['required', 'numeric', 'exists:users,id'],
                'restaurant_id' => ['required', 'numeric', 'exists:restaurants,id'],
                'images' => ['required', 'array', new ImagesArraySize],
                'images.*' => 'filled'
            ];

            // Define validation messages
            $messages = [
                'title.required' => 'El título es requerido.',
                'title.string' => 'El título solo debe contener letras y números.',
                'title.max' => 'El título debe ser máximo de 100 caracteres.',
                
                'description.required' => 'La descripción es requerida.',
                'description.string' => 'La descripción solo debe contener letras y números.',

                'user_id.required' => 'El ID del usuario es requerido.',
                'user_id.numeric' => 'El ID del usuario solo debe contener números',
                'user_id.exists' => 'El ID del usuario no existe.',

                'restaurant_id.required' => 'El ID del restaurante es requerido.',
                'restaurant_id.numeric' => 'El ID del restaurante solo debe contener números',
                'restaurant_id.exists' => 'El ID del restaurante no existe.',

                'images.required' => 'Al menos una imagen es requerida.',
                'images.array' => 'Las imágenes deben ser enviadas en un array.',
                'images.*.filled' => 'Cada elemento del arreglo de imágenes debe estar lleno.'
            ];

            // Instance validator
            $validator = Validator::make($request->all(), $rules, $messages);

            // Check if request has validation messages
            if ($validator->fails()) {

                DB::rollBack();

                // Return response with validation messages
                return response()->json([
                    "status" => "failed",
                    "data" => null,
                    "message" => $validator->messages()
                ], 422);
            }


            // Find review
            $data = Review::findOrFail($id);

            // If user is not the owner, decline
            if($data->user_id != $request->user_id){
                DB::rollBack();
                return response()->json([
                    "status" => "failed",
                    "data" => null,
                    "message" => [
                        "title" => ["Solo el propietario de la review puede realizar modificaciones."]
                    ]
                ], 401);

            }

            // Update review
            $data->fill($request->all());
            $data->save();


            // Delete all images assigned to the review
            $oldImages = ReviewImage::where('review_id', $data->id)
                         ->get();

            if(count($oldImages) > 0){
                foreach($oldImages as $oldImage){
                    $oldImage->delete();
                }
            }

            // Store the new images
            foreach($request->images as $requestImage){
                
                $imageData = substr($requestImage, strpos($requestImage, ',') + 1);
                
                $reviewImage = new ReviewImage();
                $reviewImage->image = $imageData;
                $reviewImage->review_id = $data->id;
                $reviewImage->save();
            }

            DB::commit();

            // Return successful response with the updated review
            return response()->json([
                "status" => "success",
                "data" => $data,
                "message" => [
                    "title" => ["Se ha editado la review correctamente."]
                ]
            ]);


        } catch(Exception $exception) {

            DB::rollBack();

            return response()->json([
                "status" => "error",
                "data" => null,
                "message" => [
                    "error" => [$exception->getMessage()]
                ]
            ], 500);
        }
    }


    public function delete($review_id, $user_id){

        try {

            DB::beginTransaction();
            
            // Define rules to validations
            $rules = [
                'user_id' => ['required', 'numeric', 'exists:users,id'],
                'review_id' => ['required', 'numeric', 'exists:reviews,id']
            ];

            // Define validation messages
            $messages = [
                'user_id.required' => 'El ID del usuario es requerido.',
                'user_id.numeric' => 'El ID del usuario solo debe contener números',
                'user_id.exists' => 'El ID del usuario no existe.',

                'review_id.required' => 'El ID de la review es requerido.',
                'review_id.numeric' => 'El ID de la review solo debe contener números',
                'review_id.exists' => 'El ID de la review no existe.'
            ];

            // Instance validator
            $validator = Validator::make(['user_id' => $user_id, 'review_id' => $review_id], $rules, $messages);

            // Check if request has validation messages
            if ($validator->fails()) {

                DB::rollBack();

                // Return response with validation messages
                return response()->json([
                    "status" => "failed",
                    "data" => null,
                    "message" => $validator->messages()
                ], 422);
            }


            // Find review
            $data = Review::findOrFail($review_id);

            // If user is not the owner, decline
            if($data->user_id != $user_id){
                DB::rollBack();
                return response()->json([
                    "status" => "failed",
                    "data" => null,
                    "message" => [
                        "title" => ["Solo el propietario de la review puede eliminar la review."]
                    ]
                ], 401);

            }

            // Delete review
            $data->delete();


            // Delete all images assigned to the review
            $oldImages = ReviewImage::where('review_id', $data->id)->get();
            if(count($oldImages) > 0){
                foreach($oldImages as $oldImage){
                    $oldImage->delete();
                }
            }


            // Delete all FavoriteReviews records assigned to the review
            $favoriteReviews = FavoriteReview::where('review_id', $data->id)->get();
            if(count($favoriteReviews) > 0){
                foreach($favoriteReviews as $favoriteReview){
                    $favoriteReview->delete();
                }
            }


            DB::commit();

            // Return successful response with the updated review
            return response()->json([
                "status" => "success",
                "data" => $data,
                "message" => [
                    "title" => ["Se ha eliminado la review correctamente."]
                ]
            ]);


        } catch(Exception $exception) {

            DB::rollBack();

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
