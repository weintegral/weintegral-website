<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SeoController;
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
Route::get('/blog', function () {
    return redirect('https://blog.weintegral.com');
});

/*
|--------------------------------------------------------------------------
| Company Management
|--------------------------------------------------------------------------
*/
Route::get('/team', [ManagementController::class, 'teamAction'])->name('teamPage');

Route::get('/contact', [ManagementController::class, 'contactAction'])->name('contactPage');

Route::get('/marketing-data', [ManagementController::class, 'marketingSubmissionAction'])->name('marketingSubmissionPage');

Route::get('/data', [ManagementController::class, 'marketingDataAction'])->name('marketingDataPage');

/*
|--------------------------------------------------------------------------
| Useful Resources
|--------------------------------------------------------------------------
*/
Route::get('/resources', [ResourceController::class, 'indexAction'])->name('resourcePage');

Route::get('/mgmt-resources', [ResourceController::class, 'mgmtAction'])->name('mgmtResourcePage');

Route::get('/vendors', [ResourceController::class, 'vendorAction'])->name('vendorsPage');

Route::get('/job-portals', [ResourceController::class, 'jobPortalAction'])->name('jobPortalsPage');

Route::get('/client-list', [ResourceController::class, 'clientAction'])->name('clientListPage');

Route::get('/job-groups', [ResourceController::class, 'jobGroupsAction'])->name('jobGroupListPage');

/*
|--------------------------------------------------------------------------
| Search Engines
|--------------------------------------------------------------------------
*/
Route::get('/sitemap.xml', [SeoController::class, 'sitemapAction'])->name('sitemap');

Route::get('/robots.txt', [SeoController::class, 'robotsAction'])->name('robots');

/*
|--------------------------------------------------------------------------
| Redirects
|--------------------------------------------------------------------------
*/
Route::get('/apps', function () {
    return redirect('https://lnk.bio/weintegral');
});

/*
|--------------------------------------------------------------------------
| Removed Surfaces
|--------------------------------------------------------------------------
|
| These paths once served SendPortal and the Orchid admin panel. They
| return 404 rather than falling through to the home page redirect, so the
| removal is explicit.
|
*/
Route::any('/sendportal/{path?}', function () {
    abort(404);
})->where('path', '.*');

Route::any('/admin/{path?}', function () {
    abort(404);
})->where('path', '.*');

/*
|--------------------------------------------------------------------------
| Fallback
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return redirect()->route('homePage');
});
