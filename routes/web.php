<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('welcome');

Route::get('/contactUs', [App\Http\Controllers\WelcomeController::class, 'contactUs'])->name('contactUs');

Route::post('/submitContactUs', [App\Http\Controllers\WelcomeController::class, 'submitContactUs'])->name('submitContactUs');

Route::get('message', function () {
    $message['user'] = "John Doe";
    $message['message'] = "Prueba measdlkfjals";
    $success = event(new App\Events\NewMessage($message));
    return $success;
});

Route::middleware(['auth', 'CheckUnread'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/request', [App\Http\Controllers\MessageController::class, 'index'])->name('request');

    Route::get('/inbox', [App\Http\Controllers\MessageController::class, 'index'])->name('inbox');

    Route::get('/collaboration/{item}', [App\Http\Controllers\TaskController::class, 'index'])->name('task');

    Route::get('/collaborations/{request_id}', [App\Http\Controllers\TaskController::class, 'taskDetailShow'])->name('taskDetail');

    Route::get('/disputeChat/{request_id}', [App\Http\Controllers\MessageController::class, 'disputeChat'])->name('disputeChat');

    Route::get('/search', [App\Http\Controllers\TaskController::class, 'search'])->name('search');

    Route::get('/findInfluencers', [App\Http\Controllers\TaskController::class, 'findInfluencers']);

    Route::get('balance', [App\Http\Controllers\PaymentController::class, 'balance'])->name('balance');

    Route::get('referrals', [App\Http\Controllers\ReferralsController::class, 'index'])->name('referrals');

    Route::get('saved', [App\Http\Controllers\ProfileController::class, 'saved'])->name('saved');

    Route::post('checkout', [App\Http\Controllers\PaymentController::class, 'checkout'])->name('checkout');

    Route::post('withdraw', [App\Http\Controllers\PaymentController::class, 'withdraw'])->name('withdraw');

    Route::get('accountSetting', [App\Http\Controllers\HomeController::class, 'accountSetting'])->name('accountSetting');

    Route::post('updateAccount', [App\Http\Controllers\HomeController::class, 'updateAccount'])->name('updateAccount');

    Route::get('deleteAccount', [App\Http\Controllers\HomeController::class, 'deleteAccount'])->name('deleteAccount');

    Route::get('/collaborate/{user_id}', [App\Http\Controllers\CollaborateController::class, 'index'])->name('collaborate');

    Route::post('/request/save', [App\Http\Controllers\CollaborateController::class, 'saveRequest'])->name('saveRequest');

    Route::get('editProfile/{username}', [App\Http\Controllers\ProfileController::class, 'editProfile'])->name('editProfile');

    Route::post('updateProfile/{user_id}', [App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('updateProfile');

    Route::get('leaveReview/{request_id}', [App\Http\Controllers\CollaborateController::class, 'leaveReview'])->name('leaveReview');

    Route::get('blog/{news_id}', [App\Http\Controllers\HomeController::class, 'blog'])->name('blog');
});

Route::middleware(['CheckUnread'])->group(function () {
    Route::get('/{username}', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
});

Route::get('referral/{ref_link}', [App\Http\Controllers\ReferralsController::class, 'newUser'])->name('newUser')->where('ref_link', '[a-z0-9]{128}+');

Route::middleware(['auth', 'checkAdmin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/home', [App\Http\Controllers\AdminController::class, 'index'])->name('adminDashboard');

        Route::get('/news', [App\Http\Controllers\AdminController::class, 'news'])->name('news');

        Route::post('/saveNews', [App\Http\Controllers\AdminController::class, 'saveNews'])->name('saveNews');

        Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users');

        Route::get('/projects', [App\Http\Controllers\AdminController::class, 'projects'])->name('projects');

        Route::get('/referrals', [App\Http\Controllers\AdminController::class, 'referrals'])->name('adminReferrals');

        Route::get('/cancelReferral', [App\Http\Controllers\AdminController::class, 'calcelReferral'])->name('cancelReferral');

        Route::get('/extras', [App\Http\Controllers\AdminController::class, 'extras'])->name('extras');

        Route::get('/submitAdminReview', [App\Http\Controllers\AdminController::class, 'submitAdminReview'])->name('submitAdminReview');

        Route::get('/verifyUser', [App\Http\Controllers\AdminController::class, 'verifyUser'])->name('verifyUser');

        Route::get('/featureUser', [App\Http\Controllers\AdminController::class, 'featureUser'])->name('featureUser');

        Route::get('/unFeatureUser', [App\Http\Controllers\AdminController::class, 'unFeatureUser'])->name('unFeatureUser');

        Route::get('/deleteUser', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('deleteUser');

        Route::get('/blockUser', [App\Http\Controllers\AdminController::class, 'blockUser'])->name('blockUser');

        Route::get('/loginAsUser', [App\Http\Controllers\AdminController::class, 'loginAsUser'])->name('loginAsUser');

        Route::get('/allUsers/{accountType}', [App\Http\Controllers\AdminController::class, 'allUsers'])->name('allUsers');
    });
});
