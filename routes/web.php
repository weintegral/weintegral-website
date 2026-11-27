<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\InternalToolsController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\ServiceController;
use App\Http\Middleware\NoIndex;
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

Route::get('/services', [ServiceController::class, 'indexAction'])->name('servicesPage');

// The Clients page (and any client detail URL) was dropped by owner decision.
Route::permanentRedirect('/clients/{path?}', '/about')->where('path', '.*');

Route::get('/industries', [AboutController::class, 'industriesAction'])->name('industriesPage');

Route::get('/terms-of-service', [AboutController::class, 'termsOfServiceAction'])->name('termsOfServicePage');

Route::get('/privacy-policy', [AboutController::class, 'privacyPolicyAction'])->name('privacyPolicyPage');

/*
|--------------------------------------------------------------------------
| Services We Provide
|--------------------------------------------------------------------------
*/
Route::get('/app-development', [ServiceController::class, 'showAction'])->defaults('service', 'app-development')->name('appDevelopmentPage');

Route::get('/app-support', [ServiceController::class, 'showAction'])->defaults('service', 'app-support')->name('appSupportPage');

Route::get('/testing', [ServiceController::class, 'showAction'])->defaults('service', 'testing')->name('testingPage');

Route::get('/devops', [ServiceController::class, 'showAction'])->defaults('service', 'devops')->name('devopsPage');

Route::get('/staffing', [ServiceController::class, 'showAction'])->defaults('service', 'staffing')->name('staffingPage');

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

/*
|--------------------------------------------------------------------------
| Useful Resources
|--------------------------------------------------------------------------
*/
Route::get('/resources', [ResourceController::class, 'indexAction'])->name('resourcePage');

/*
|--------------------------------------------------------------------------
| Internal Tools
|--------------------------------------------------------------------------
|
| Staff-only pages: reachable by URL, marked noindex, and absent from the
| public navigation and the sitemap.
|
*/
Route::middleware(NoIndex::class)->controller(InternalToolsController::class)->group(function () {
    Route::get('/mgmt-resources', 'companySystemsAction')->name('companySystemsPage');
    Route::get('/vendors', 'vendorsAction')->name('vendorsPage');
    Route::get('/job-portals', 'jobPortalsAction')->name('jobPortalsPage');
    Route::get('/client-list', 'clientListAction')->name('clientListPage');
    Route::get('/job-groups', 'jobGroupsAction')->name('jobGroupListPage');
    Route::get('/marketing-data', 'marketingSubmissionsAction')->name('marketingSubmissionPage');
    Route::get('/data', 'marketingDataAction')->name('marketingDataPage');
});

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
