<?php
use App\Http\Controllers\API\Backend\Blog\BlogController;
use App\Http\Controllers\API\Backend\Page\PageController;
use App\Http\Controllers\API\Backend\Story\StoryController;
use App\Http\Controllers\API\Backend\Order\OrderController;
use App\Http\Controllers\API\Frontend\Order\OrderController as orderFrontend;
use App\Http\Controllers\API\Backend\Category\CategoryController;
use App\Http\Controllers\API\Backend\Country\CountryControler;
use App\Http\Controllers\API\Backend\Dashboard\DashboardController;
use App\Http\Controllers\API\Backend\Mail\MailController;
use App\Http\Controllers\API\Backend\PaymentMethods\Nagad\NagadController;
use App\Http\Controllers\API\Backend\Customer\CustomerController;
use App\Http\Controllers\API\Backend\Product\ProductController;
use App\Http\Controllers\API\Backend\Tag\TagController;
use App\Http\Controllers\API\Backend\Blog\BlogTagController;
use App\Http\Controllers\API\Backend\Blog\CategoryTagController;
use App\Http\Controllers\API\Backend\Story\StoryTagController;
use App\Http\Controllers\API\Backend\Joblist\JoblistController;
use App\Http\Controllers\API\Backend\Joblist\JobCategoryController;
use App\Http\Controllers\API\Backend\Joblist\JobLocationController;
use App\Http\Controllers\API\Backend\Settings\SettingsController;
use App\Http\Controllers\API\Backend\Settings\ProductPageController;
use App\Http\Controllers\API\Backend\FAQ\FaqController;
use App\Http\Controllers\API\Backend\Settings\HomePageController;
use App\Http\Controllers\API\Backend\Settings\AboutPageController;
use App\Http\Controllers\API\Backend\Settings\ContactController;
use App\Http\Controllers\API\Backend\Settings\CareerListingController;
use App\Http\Controllers\API\Backend\Settings\StoriesController;
use App\Http\Controllers\API\Backend\Email\EmailHistoryController;
use App\Http\Controllers\API\Backend\Team\TeamController;

use App\Http\Controllers\Payments\PaymentsController;
use App\Http\Controllers\Payments\TransactionController;
use App\Http\Controllers\API\Backend\Cart\CartController;
use App\Http\Controllers\API\Backend\Order\OrderProductController;
use App\Http\Controllers\API\Frontend\Profile\CustomerAuthController;
use App\Http\Controllers\LoginController;
  
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\Payments\BkashController;
use App\Models\Shipping\City;
use App\Models\Shipping\Zone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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


Route::post('admin/custom/login',[DashboardController::class, 'loginCustom']);
Route::post('admin/custom/login', 'App\Http\Controllers\API\Backend\Dashboard\DashboardController@loginCustom');
Route::get('/csrf', function () {
    echo csrf_token();
    return view('welcome');
});
Route::get('send-email', [MailController::class, 'index']);

Route::get('/test', [FrontEndController::class, 'test']);


Route::get('/admin_faq/api/{faq_id}',  [FaqController::class, 'faqApi'])->name('faqApi');



Route::post('add-to-cart', [CartController::class, 'store']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::post('/admin/category/submit', [CategoryController::class, 'store']);
Route::get('/admin/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
$router->group( ['middleware' => 'auth:web'] , function($router) {
    
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
});

Route::resource('/admin/product',  ProductController::class,['names' => 'product']);
Route::resource('/admin/blog',  BlogController::class,['names' => 'blog']);
Route::get('/admin/blog/{id}',[BlogController::class,'delete'])->name('blog.delete');
Route::resource('/admin/category',  CategoryController::class,['names' => 'category']);


//Route::resource('/admin/stories',  BlogController::class);
Route::resource('/admin/story',  StoryController::class,['names' => 'stories']);
Route::resource('/order/list',  OrderController::class,['names' => 'order']);
Route::resource('/admin/pages',  PageController::class,['names' => 'page']);
Route::resource('/admin/product/tag',  TagController::class,['names' => 'tags']);
Route::resource('/admin/blog/tag',  BlogTagController::class,['names' => 'tag']);
Route::resource('/admin/blog/category/tag',  CategoryTagController::class,['names' => 'categorytag']);

Route::resource('/admin/stories/tag',  StoryTagController::class,['names' => 'sotrytag']);
//Route::resource('/admin/contact',  SettingsController::class,['names' => 'setting']);

Route::get('/mail/test',[SettingsController::class,'mailTest'])->name('mail.test');

Route::resource('/admin/faqs',  FaqController::class,['names' => 'faq']);
Route::get('/admin/terms',[FaqController::class,'termView']);
Route::post('/admin/terms/save',[FaqController::class,'termSave'])->name('term');
Route::resource('/payments',  PaymentsController::class,['names' => 'payment']);
Route::resource('/transaction/history',  TransactionController::class,['names' => 'tarnsaction']);
// Page Settings
Route::post('/admin/setting/save',[SettingsController::class,'adminSetUpStore'])->name('setup');
Route::get('/admin/contact',[ContactController::class,'contactView']);
Route::post('/contact-save',[ContactController::class,'SaveContact'])->name('save-contact');
//Route::post('/contact-save',[SettingsController::class,'SaveContact'])->name('save-contact');
Route::get('/admin/home',[HomePageController::class,'homeView'])->name('home-view');
Route::post('/home-save',[HomePageController::class,'homeSave'])->name('home-save');
Route::post('/home-save-hub',[HomePageController::class,'homeSavehub'])->name('homeSavehub');
Route::post('/home-save-product',[HomePageController::class,'homeSaveproduct'])->name('homeSaveproduct');
Route::get('/admin/about',[AboutPageController::class,'aboutView'])->name('about-view');


Route::group(['middleware' => ['web']], function () {
    Route::post('/about-save',[AboutPageController::class,'aboutSave'])->name('about-save');   
});
Route::get('/admin/career-listing',[CareerListingController::class,'careerListingView'])->name('career-view');
Route::post('/admin/career-listing/save',[CareerListingController::class,'careerSave'])->name('career-save');
Route::get('/admin/stories',[StoriesController::class,'storiesView'])->name('stories-view');
Route::post('/admin/stories/save',[StoriesController::class,'storiesSave'])->name('stories-save');

Route::post('api/customer/register', [CustomerAuthController::class, 'CustRegister']);
Route::post('api/customer/login',[CustomerAuthController::class, 'CustLogin']);
Route::post('api/customer/logout',[CustomerAuthController::class, 'customerLogout']);
Route::get('customer/list',[CustomerController::class, 'customerList']);
Route::get('email/history',[EmailHistoryController::class, 'emailHistory']);
Route::get('email/history/{id}',[EmailHistoryController::class, 'Delete'])->name('email.delete');

// Route::get('api/get-my-order', [orderFrontend::class, 'index']);


// Route::group([ 'middleware' => 'auth:customers'], function () {
//  // login register section
//     Route::post('customer/validation',[CustomerAuthController::class, 'CustValidation']);
//     Route::post("check-auth",[CustomerAuthController::class,'check_auth']);
//     Route::post('customer/forget-password',[CustomerAuthController::class, 'forgetPassword']);
//     Route::post('customer/reset-password',[CustomerAuthController::class, 'resetPassword']);
// });   
// });
Route::get('/admin/setting',[SettingsController::class,'adminSetUp'])->name('setup');
// $router->group( ['middleware' => 'auth'] , function($router) {
Route::group(['middleware' => ['web']], function () {
   Route::resource('/admin/joblist',  JoblistController::class,['names' => 'joblist']); 
   Route::resource('/admin/joblist/categories',  JobCategoryController::class,['names' => 'categories']); 
   Route::resource('/admin/joblist/locations',  JobLocationController::class,['names' => 'locations']); 
   Route::resource('/admin/product/page',  ProductPageController::class,['names' => 'product-page']); 
   Route::get('/admin/aply/joblist',[JoblistController::class, 'aplyJobList'])->name('aply-job');
});
// });

// Team Setup 
Route::resource('/admin/team',  TeamController::class,['names' => 'team']);
 
Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});
// User Setup
Route::get('/admin/user/setup',[LoginController::class,'userSetup']);
Route::post('/admin/user/save',[LoginController::class,'userStore'])->name('user.setup');
Route::get('/admin/userlist',[LoginController::class,'userView'])->name('user.view');
Route::get('/admin/userlist/delete/{id}',[LoginController::class,'delete'])->name('user.delete');
Route::get('/admin/userlist/edit/{id}',[LoginController::class,'userEdit'])->name('user.edit');
Route::post('/admin/userlist/update/{id}',[LoginController::class,'userUpdate'])->name('user.update');