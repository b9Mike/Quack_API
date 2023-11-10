<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\RestaurantController;
use App\Http\Controllers\API\FavoriteRestaurantController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\FavoriteReviewController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::controller(UserController::class)->name('users.')->group(function () { 

    // Get current user
    Route::get('user', 'currentUser')->name('current-user');

    // Get user details
    Route::get('user/{id}', 'userDetails')->name('user-details');

    // Get user profile
    Route::get('user/{id}/profile', 'profile')->name('profile');

    // Edit information
    Route::put('user/edit-information/{id}', 'updateInformation')->name('edit-information');

    // Edit password
    Route::put('user/edit-password/{id}', 'updatePassword')->name('edit-password');
});

// Restaurant routes
Route::controller(RestaurantController::class)->name('restaurants.')->group(function () {

    // Search restaurants by text
    Route::get('restaurant/search', 'listRestaurantsByText')->name('search-by-text');

    // Get all restaurants ordered by date ASC
    Route::get('restaurants/order-by-date-asc', 'listRestaurantsOrderedByDateAsc')->name('restaurants-ordered-by-date-asc');

    // Get all Restaurants ordered by date DESC
    Route::get('restaurants/order-by-date-desc', 'listRestaurantsOrderedByDateDesc')->name('restaurants-ordered-by-date-desc');

    // Get all Restaurants ordered by ID ASC
    Route::get('restaurants/order-by-id-asc', 'listRestaurantsOrderedByIdAsc')->name('restaurants-ordered-by-id-asc');

    // Get all Restaurants ordered by ID DESC
    Route::get('restaurants/order-by-id-desc', 'listRestaurantsOrderedByIdDesc')->name('restaurants-ordered-by-id-desc');

    // Get Restaurant details
    Route::get('restaurant/{id}/user/{userId}', 'RestaurantDetails')->name('restaurant-details');

    // Get popular Restaurants
    Route::get('restaurants/popular', 'popularRestaurants')->name('popular-restaurant');
});

// Favorite Restaurant routes
Route::controller(FavoriteRestaurantController::class)->name('restaurants.')->group(function () {

    // Get user favorite Restaurants
    Route::get('restaurant/user-favorite/{id}', 'userFavoriteRestaurants')->name('user-favorite-restaurants');

    // Add Restaurants to favorites
    Route::post('restaurant/favorite/add', 'store')->name('restaurant-favorite-add');

    // Delete favorite Restaurants
    Route::delete('restaurant/{restaurantId}/user/{userId}/favorite/delete', 'delete')->name('restaurant-favorite-delete');
});

// Review routes
Route::controller(ReviewController::class)->name('reviews.')->group(function () {

    // Get reviews by text
    Route::get('reviews/search', 'listReviewsByText')->name('search-by-text');

    // Get reviews ordered by Date ASC
    Route::get('reviews/order-by-date-asc', 'listReviewsOrderedByDateAsc')->name('order-by-date-asc');

    // Get reviews ordered by Date DESC
    Route::get('reviews/order-by-date-desc', 'listReviewsOrderedByDateDesc')->name('order-by-date-desc');

    // Get reviews ordered by ID ASC
    Route::get('reviews/order-by-id-asc', 'listReviewsOrderedByIdAsc')->name('order-by-id-asc');

    // Get reviews ordered by ID DESC
    Route::get('reviews/order-by-id-desc', 'listReviewsOrderedByIdDesc')->name('order-by-id-desc');

    // Get user reviews
    Route::get('reviews/user/{id}', 'userReviews')->name('user-reviews');

    // Get review details
    Route::get('reviews/{id}/user/{userId}', 'reviewDetails')->name('review-details');

    // Store review
    Route::post('reviews/create', 'store')->name('store');

    // Update review
    Route::put('reviews/update/{id}', 'update')->name('update');

    // Update review
    Route::delete('reviews/{review_id}/user/{user_id}/delete', 'delete')->name('delete');
});

// Favorite Review routes
Route::controller(FavoriteReviewController::class)->name('reviews.')->group(function () {

    // Get user favorite reviews
    Route::get('reviews/user-favorite/{id}', 'userFavoriteReviews')->name('user-favorite-reviews');

    // Add review to favorites
    Route::post('reviews/favorite/add', 'store')->name('add-favorite-review');

    // Delete favorite review from favorites
    Route::delete('reviews/{review_id}/user/{user_id}/favorite/delete', 'delete')->name('delete-favorite-review');
});

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */
