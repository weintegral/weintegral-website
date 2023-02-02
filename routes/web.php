<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\ManagementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/

/*
|--------------------------------------------------------------------------
| About Firm
|--------------------------------------------------------------------------
*/
Route::get('/', [HomePageController::class, 'indexAction'])->name('homePage');

Route::get('/about', [AboutController::class, 'aboutAction'])->name('aboutCompanyPage');

Route::get('/services', [AboutController::class, 'servicesAction'])->name('servicesPage');

Route::get('/clients', [AboutController::class, 'clientsAction'])->name('clientsPage');

Route::get('/industries', [AboutController::class, 'industriesAction'])->name('industriesPage');

/*
|--------------------------------------------------------------------------
| Career & Job Openings
|--------------------------------------------------------------------------
*/
Route::get('/career', [CareerController::class, 'indexAction'])->name('careerIndexPage');

Route::get('/career/work-culture', [CareerController::class, 'cultureAction'])->name('workCulturePage');

Route::get('/career/benefits', [CareerController::class, 'benefitsAction'])->name('benefitsPage');

Route::get('/career/openings', [CareerController::class, 'jobOpeningsAction'])->name('jobOpeningsPage');

/*
|--------------------------------------------------------------------------
| Blog Posts
|--------------------------------------------------------------------------
*/
Route::get('/blog', [BlogController::class, 'indexAction'])->name('blogIndexPage');

/*
|--------------------------------------------------------------------------
| Company Management
|--------------------------------------------------------------------------
*/
Route::get('/team', [ManagementController::class, 'teamAction'])->name('teamPage');

Route::get('/contact', [ManagementController::class, 'contactAction'])->name('contactPage');
