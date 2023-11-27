<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ServiceController;
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

Route::get('/terms-of-service', [AboutController::class, 'termsOfServiceAction'])->name('termsOfServicePage');

Route::get('/privacy-policy', [AboutController::class, 'privacyPolicyAction'])->name('privacyPolicyPage');

/*
|--------------------------------------------------------------------------
| Services We Provide
|--------------------------------------------------------------------------
*/
Route::get('/app-development', [ServiceController::class, 'appDevelopmentAction'])->name('appDevelopmentPage');

Route::get('/app-support', [ServiceController::class, 'appSupportAction'])->name('appSupportPage');

Route::get('/testing', [ServiceController::class, 'testingAction'])->name('testingPage');

Route::get('/devops', [ServiceController::class, 'devopsAction'])->name('devopsPage');

Route::get('/staffing', [ServiceController::class, 'staffingAction'])->name('staffingPage');

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

Route::get('/blog/single', [BlogController::class, 'singleArticleAction'])->name('singleArticlePage');

/*
|--------------------------------------------------------------------------
| Company Management
|--------------------------------------------------------------------------
*/
Route::get('/team', [ManagementController::class, 'teamAction'])->name('teamPage');

Route::get('/contact', [ManagementController::class, 'contactAction'])->name('contactPage');

/*
|--------------------------------------------------------------------------
| Useful Resources
|--------------------------------------------------------------------------
*/
Route::get('/resources', [ResourceController::class, 'indexAction'])->name('resourcePage');

Route::get('/vendors', [ResourceController::class, 'vendorAction'])->name('vendorsPage');

Route::get('/job-portals', [ResourceController::class, 'jobPortalAction'])->name('jobPortalsPage');

Route::get('/client-list', [ResourceController::class, 'clientAction'])->name('clientListPage');

/*
|--------------------------------------------------------------------------
| Redirects
|--------------------------------------------------------------------------
*/
Route::get('/crm', function () {
    return redirect('https://app.hubspot.com');
});

Route::get('/kanban', function () {
    return redirect('https://app.plane.so/weintegral');
});

Route::get('/e-sign', function () {
    return redirect('https://app.signfree.io/home/dashboard');
});

Route::get('/accounting', function () {
    return redirect('https://next.waveapps.com');
});

Route::get('/wiki', function () {
    return redirect('https://docs.weintegral.com');
});

Route::get('/guides', function () {
    return redirect('https://scribehow.com/');
});

Route::get('/feedback', function () {
    return redirect('https://tally.so/dashboard');
});

/*
|--------------------------------------------------------------------------
| Fallback
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return redirect()->route('homePage');
});
