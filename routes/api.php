<?php

use App\Http\Controllers\API\Backend\FAQ\FaqController;
use App\Http\Controllers\API\Backend\Banner\BannerController;
use App\Http\Controllers\API\Backend\Blog\BlogController;
use App\Http\Controllers\API\Backend\Brand\BrandController;
use App\Http\Controllers\API\Backend\Cart\CartController;
use App\Http\Controllers\API\Backend\Category\CategoryController;
use App\Http\Controllers\API\Backend\ContactMail\ContactMailController;
use App\Http\Controllers\API\Backend\Country\CountryControler;
use App\Http\Controllers\API\Backend\Coupon\CouponController;
use App\Http\Controllers\API\Backend\Customer\CustomerController;
use App\Http\Controllers\API\Backend\Dashboard\DashboardController;
use App\Http\Controllers\API\Backend\Delivery\DeliveryZoneController;
use App\Http\Controllers\API\Backend\Delivery\ProductDeliveryInformationController;
use App\Http\Controllers\API\Backend\Grocery\GroceryCartController;
use App\Http\Controllers\API\Backend\Mail\MailController;
use App\Http\Controllers\API\Backend\Media\MediaController;
use App\Http\Controllers\API\Backend\Notification\NotificationController;
use App\Http\Controllers\API\Backend\Order\GlobalOrderController;
use App\Http\Controllers\API\Backend\Order\OrderProductController;
use App\Http\Controllers\API\Backend\Order\OrderStatusController;
use App\Http\Controllers\API\Backend\PageContent\PageContentController;
use App\Http\Controllers\API\Backend\PaymentMethod\PaymentMethodController;
use App\Http\Controllers\API\Backend\Shipping\ShippingController;
use App\Http\Controllers\API\Backend\SMS\SMSController;
use App\Http\Controllers\API\Backend\Store\StoreController;
use App\Http\Controllers\API\Backend\Store\StoreLikeController;
use App\Http\Controllers\API\Backend\Ticket\TicketController;
use App\Http\Controllers\API\Backend\Ticket\TicketStatusController;
use App\Http\Controllers\API\Backend\Joblist\JoblistController;
use App\Http\Controllers\API\Backend\Transaction\TransactionController;
use App\Http\Controllers\API\Frontend\Address\FrontCustomerAddressController;
use App\Http\Controllers\API\Frontend\Blog\FrontendBlogController;
use App\Http\Controllers\API\Frontend\Cart\BuyNowController;
use App\Http\Controllers\API\Frontend\ContactUs\ContactUsController;
use App\Http\Controllers\API\Frontend\Coupon\FrontendCouponController;
use App\Http\Controllers\API\Frontend\DeliveryCharge\DeliveryChargeController;
// use App\Http\Controllers\API\Frontend\Global\GlobalProductController;
use App\Http\Controllers\API\Frontend\NewsLetter\FrontendNewsLetterController;
use App\Http\Controllers\API\Frontend\Order\OrderController;
use App\Http\Controllers\API\Backend\Order\OrderController as BackendOrderController;
use App\Http\Controllers\API\Backend\Price\PriceCalculatorController;
use App\Http\Controllers\API\Backend\Product\ProductController;
use App\Http\Controllers\API\Backend\Product\ProductFAQController;
use App\Http\Controllers\API\Backend\Product\ProductPhotoController;
use App\Http\Controllers\API\Backend\Product\ProductSpecificationController;
use App\Http\Controllers\API\Backend\Product\ProductTypeController;
use App\Http\Controllers\API\Backend\Product\ProductVideoController;
use App\Http\Controllers\API\Backend\ProductVariation\GenerateVariationController;
use App\Http\Controllers\API\Backend\ProductVariation\ProductAttributeController;
use App\Http\Controllers\API\Backend\ProductVariation\ProductAttributeValueController;
use App\Http\Controllers\API\Backend\Review\ReviewController;
use App\Http\Controllers\API\Backend\Team\TeamController;
use App\Http\Controllers\API\Backend\Review\ReviewReplayController;
use App\Http\Controllers\API\Backend\Role\RoleController;
use App\Http\Controllers\API\Frontend\Address\AddressController;
use App\Http\Controllers\API\Backend\Address\AddressController as BackendAddressController;
use App\Http\Controllers\API\Frontend\ChildProductController;
use App\Http\Controllers\API\Frontend\Grocery\GroceryController;
use App\Http\Controllers\API\Frontend\Order\GroceryOrderController;
use App\Http\Controllers\API\Backend\Order\GroceryOrderController as BackendGroceryOrderController;
use App\Http\Controllers\API\Frontend\PageContent\FrontendPageContent;
use App\Http\Controllers\API\Frontend\ProductVariationController;
use App\Http\Controllers\API\Frontend\Profile\ProfileController;
use App\Http\Controllers\API\Backend\User\UserSetupController;
use App\Http\Controllers\API\Backend\Shipping\DistrictController;
use App\Http\Controllers\API\Backend\Shipping\DivisionController;
use App\Http\Controllers\API\Backend\SiteContentController;
use App\Http\Controllers\API\Backend\Slider\SliderController;
use App\Http\Controllers\API\Backend\Tag\TagController;
use App\Http\Controllers\API\Backend\Settings\ContactController;
use App\Http\Controllers\API\Frontend\ProductController as FrontProductController;
use App\Http\Controllers\API\Frontend\Review\FrontendReviewController;
use App\Http\Controllers\API\Frontend\SliderController as FrontendSliderController;
use App\Http\Controllers\API\Frontend\BannerController as FrontendBannerController;
use App\Http\Controllers\API\Frontend\BrandController as FrontendBrandController;
use App\Http\Controllers\API\Frontend\CategoryController as FrontEndCategoryController;
use App\Http\Controllers\API\Frontend\Ticket\FrontendTicketController;
use App\Http\Controllers\API\Frontend\Transaction\FrontendTransactionController;
use App\Http\Controllers\API\Frontend\Wishlist\FrontendWishListController;
use App\Http\Controllers\API\PriceCalculator;
use App\Http\Controllers\API\Frontend\Profile\CustomerAuthController;
use App\Http\Controllers\APIAuthenticationController;
use App\Http\Controllers\API\Backend\Settings\StoriesController;
use App\Http\Controllers\API\Backend\Settings\AboutPageController;
use App\Http\Controllers\API\Backend\Settings\HomePageController;
use App\Http\Controllers\API\Backend\Settings\SettingsController;
use App\Http\Controllers\API\Backend\Story\StoryController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




//auth routes
Route::post('/login', [APIAuthenticationController::class, 'login']);
Route::post('/register', [APIAuthenticationController::class, 'register']);

//Route::post('upload-product-photo', [ProductPhotoController::class, 'store']);
//backend Routes
Route::group(['prefix' => 'dashboard', 'middleware' => 'auth:sanctum'], function () {

    Route::post('/logout', [APIAuthenticationController::class, 'logout']); //auth route
    Route::post('category-status-update/{id}', [CategoryController::class, 'status_update']);
    Route::post('brand-status-update/{id}', [BrandController::class, 'status_update']);
    Route::post('tags-status-update/{id}', [TagController::class, 'status_update']);
    Route::post('attribute-status-update/{id}', [ProductAttributeController::class, 'status_update']);
    Route::post('attribute-value-status-update/{id}', [ProductAttributeValueController::class, 'status_update']);
    Route::post('product-status-update/{id}', [ProductController::class, 'status_update']);
    Route::get('subCategoryList', [CategoryController::class, 'subCategoryList']);
    Route::get('allCategoryList', [CategoryController::class, 'allCategoryList']);
    Route::get('get-product-type', [ProductTypeController::class, 'get_product_type']);   //get categories for product create page
    Route::get('get-categories/{id}', [CategoryController::class, 'get_categories']);   //get categories for product create page
    Route::get('get-product-attribute', [ProductAttributeController::class, 'getAttributes']);   //get categories for product create page
    Route::get('get-brands', [BrandController::class, 'get_brands']);   //get brands for product create page
    Route::post('generate-variation', [GenerateVariationController::class, 'generate_variations']);   //get brands for product create page
    Route::post('product-variation-combination', [GenerateVariationController::class, 'product_variation_combination']);   //get brands for product create page
    Route::get('get-product-variation-combination/{id}', [GenerateVariationController::class, 'get_product_variation_combination']);   //get brands for product create page
    Route::post('add-custom-variation-field', [GenerateVariationController::class, 'add_custom_variation_field']);   //get brands for product create page

    Route::get('get-sub-categories/{id}', [CategoryController::class, 'get_sub_categories']);   //get sub categories for product create page
    Route::get('get-sub-sub-categories/{id}', [CategoryController::class, 'get_sub_sub_categories']);   //get sub categories for product create page
    Route::post('get-districts', [DistrictController::class, 'get_districts']); //get districts for delivery charge page
    Route::post('get-tag-list', [TagController::class, 'get_tag_list']); ///get tags for product create page
    Route::post('upload-product-photo', [ProductPhotoController::class, 'upload_product_photo']); //upload product photos for product create page
    Route::post('check-primary-category', [CategoryController::class, 'check_primary_category']);
    Route::post('save-child-product', [ProductController::class, 'save_child_product']);
    Route::get('get-photos-for-preview/{id}', [ProductPhotoController::class, 'get_photos_for_preview']);
    Route::post('update-primary-photo/{id}', [ProductPhotoController::class, 'update_primary_photo']);
    Route::post('get-variation-product-data-for-show', [ProductController::class, 'get_variation_product_data_for_show']);
    Route::post('delete-variation-from-product-add-page', [ProductController::class, 'delete_variation_from_product_add_page']);
    Route::get('get-product-for-edit/{slug_id}', [ProductController::class, 'get_product_for_edit']);
    Route::get('get-product-specifications-for-edit/{id}', [ProductSpecificationController::class, 'get_product_specifications_for_edit']);
    Route::post('delete-product-specifications', [ProductSpecificationController::class, 'delete_product_specifications']);
    Route::get('get-product-delivery-information-for-edit/{id}', [ProductDeliveryInformationController::class, 'show']);
    Route::post('create-product-attribute-name', [ProductAttributeController::class, 'store']);
    Route::get('get-category-for-edit-page/{id}', [CategoryController::class, 'get_category_for_edit_page']);
    Route::post('product-delete/{id}', [ProductController::class, 'delete_product']);
    Route::post('get-attribute-suggestion', [ProductAttributeController::class, 'get_attribute_suggestion']);
    Route::get('get-category-for-edit/{id}', [CategoryController::class, 'get_category_for_edit']);
    Route::post('get-items-for-coupon-create', [CouponController::class, 'get_items_for_coupon_create']);

    Route::get('get-statistics', [DashboardController::class, 'index']);
    Route::get('get-new-user', [DashboardController::class, 'get_new_user']);
    Route::get('get-recent-orders', [DashboardController::class, 'get_recent_orders']);


    Route::apiResource('category', CategoryController::class);
    Route::apiResource('brand', BrandController::class);
    Route::apiResource('tag', TagController::class);
    Route::apiResource('product', ProductController::class);
    Route::apiResource('product-image', ProductPhotoController::class);
    Route::apiResource('product-review', ReviewController::class);
    Route::apiResource('product-review-replay', ReviewReplayController::class);
    Route::apiResource('product-faq', ProductFAQController::class);
    Route::apiResource('banner', BannerController::class);
    Route::apiResource('slider', SliderController::class);
    Route::apiResource('site-content', SiteContentController::class);
    Route::apiResource('product-attribute', ProductAttributeController::class);
    Route::apiResource('product-attribute-value', ProductAttributeValueController::class);
    Route::apiResource('division', DivisionController::class);
    Route::apiResource('video', ProductVideoController::class);
    Route::apiResource('grocery-order', BackendGroceryOrderController::class);
    Route::apiResource('order', BackendOrderController::class);
    Route::apiResource('global-order', GlobalOrderController::class);
    Route::apiResource('coupon', CouponController::class);
    Route::apiResource('transaction', TransactionController::class);
    Route::apiResource('payment-method', PaymentMethodController::class);
    Route::apiResource('blog', BlogController::class);
    Route::apiResource('ticket', TicketController::class);

    //Customer
    Route::apiResource('customer', CustomerController::class);
    // Role
    Route::apiResource('role', RoleController::class);
    // User Setup
    Route::apiResource('userSetup', UserSetupController::class);
    // Profile Setup
    Route::apiResource('my-profile', ProfileController::class); //duplicate route, moved to frontend section

    //store
    Route::get('get-division', [AddressController::class, 'get_division']);
    Route::get('get-district/{id}', [AddressController::class, 'get_district']);
    Route::get('get-thana/{id}', [AddressController::class, 'get_thana']);
    Route::apiResource('store', StoreController::class);

   // country
    Route::get('get-country-list', [CountryControler::class, 'get_country_list']);
    Route::get('get-store-list', [StoreController::class, 'get_store_list']);
    Route::get('get-shipment-status', [ShippingController::class, 'get_shipment_status_list']);
    Route::post('change-order-status', [BackendOrderController::class, 'change_order_status']);
    Route::post('change-single-order-status/{order_number}', [OrderStatusController::class, 'change_single_order_status']);
    Route::post('get-order-statues/{order_number}', [OrderStatusController::class, 'index']);
    Route::post('add-transaction-to-order/{order_number}', [TransactionController::class, 'store']);
    
    Route::get('get-customer-address-for-edit/{address_id}', [BackendAddressController::class, 'get_customer_address_for_edit']);
    Route::post('update-customer-address/{address_id}', [BackendAddressController::class, 'update_customer_address']);
    Route::get('get-notifications', [NotificationController::class, 'unreadNotifications']);
    Route::get('update-notifications-as-read/{id}', [NotificationController::class, 'update_notifications_as_read']);
    Route::get('get-all-notifications', [NotificationController::class, 'index']);

    //sms
    Route::get('get-sms-balance', [SMSController::class, 'getSMSBalance']);
    Route::get('get-sms-contacts', [SMSController::class, 'getSMSContacts']);

    Route::get('check', [SMSController::class, 'check']);
    Route::get('get-sms-list', [SMSController::class, 'index']);

    Route::get('send-email', [MailController::class, 'index']);

    Route::get('get-ticket-status', [TicketStatusController::class, 'index']);

    Route::get('media-gallery', [MediaController::class, 'index']);
    Route::get('media-gallery-video', [MediaController::class, 'videos']);
    Route::post('upload-media-gallery', [MediaController::class, 'store']);

    Route::get('page-content/{id}', [PageContentController::class, 'index']);
    Route::post('page-content-update-edit', [PageContentController::class, 'update']);


   Route::get('get-contact-emails', [ContactMailController::class, 'index']);
   Route::get('get-sent-contact-emails', [ContactMailController::class, 'index_sent']);
   Route::get('get-trash-contact-emails', [ContactMailController::class, 'index_trash']);
   Route::get('get-email-details/{id}', [ContactMailController::class, 'show']);
   Route::delete('delete-email/{id}', [ContactMailController::class, 'destroy']);
   Route::put('restore-email/{id}', [ContactMailController::class, 'restore_email']);
   Route::delete('permanently-delete-email/{id}', [ContactMailController::class, 'permanently_delete_email']);

   Route::post('send-email', [ContactMailController::class, 'send_email']);

   Route::post('save-delivery-charge', [DeliveryZoneController::class, 'store']);

});

//frontend routes
Route::group(['prefix' => 'frontend'], function () {
    
    Route::post('customer/forget_password',[CustomerAuthController::class, 'forgetPasswordsendEmail']);
    Route::post('customer/password_change',[CustomerAuthController::class, 'passwordChange']);
    #product page
    Route::get('/latest/product/list',  [ProductController::class, 'productList'])->name('productList');
    Route::get('/featured/products/list',  [ProductController::class, 'featuredproductList'])->name('featuredproductList');
    Route::get('/display/products/list',  [ProductController::class, 'displayProductList'])->name('displayProductList');
    Route::get('/category/product/{slug}',  [ProductController::class, 'frontendCategoryProduct'])->name('frontendCategoryProduct');
    Route::get('/category/total/product/{slug}',  [ProductController::class, 'frontendCategoryTotalProduct'])->name('frontendCategoryTotalProduct');
     Route::get('/category_info/total/product/{slug}/{id}',  [ProductController::class, 'frontendCategoryTotalProducts'])->name('frontendCategoryTotalProducts');
    
    Route::get('/subscription/product/list',  [ProductController::class, 'subscriptionProductList'])->name('subscriptionProductList');
    Route::post('/get-categories', [FrontProductController::class, 'get_categories']);
    Route::get('/subscriptions/{slug}',  [ProductController::class, 'subscriptionProduct'])->name('subscriptionProduct');
    
    #get jobe
    Route::get('/job-opening', [JoblistController::class, 'jobOpen']);
    Route::get('/job-categories', [JoblistController::class, 'jobCategories']);
    Route::get('/job-location', [JoblistController::class, 'jobLocation']);
    Route::get('/job-team', [JoblistController::class, 'jobTeam']);
    Route::post('/apply-job', [JoblistController::class, 'applyJob']);
    Route::post('/subscribe/apply', [ContactMailController::class, 'subscribeApplyJob']);
    Route::post('/job/opening/category/filter', [JoblistController::class, 'jobOpenCategoryList']);
    Route::post('/job/opening/location/filter', [JoblistController::class, 'jobOpenLocationList']);
    Route::post('/job/opening/team/filter', [JoblistController::class, 'jobOpenTeamList']);
    Route::get('/job/page/content',  [JoblistController::class, 'jobPageContent'])->name('jobPageContent');
    Route::get('/single/job/{slug}',  [JoblistController::class, 'singlejob'])->name('singlejob');
    
    #contact PageApi
    Route::post('/contact-send-us', [ContactController::class, 'contactUsSend']);
    Route::get('/contact/api',  [ContactController::class, 'contactApi'])->name('contactApi');
    Route::get('/contact/content',  [ContactController::class, 'contactContent'])->name('contactContent');
    
    #blog page
    Route::get('/blog/list',  [BlogController::class, 'blogApi'])->name('blogApi');
    Route::get('/blog/page/{id}',  [BlogController::class, 'singlePage'])->name('singlePage');
    Route::get('/blog/upcomming/post',  [BlogController::class, 'blogApi'])->name('blogApi');
    
    
    #story page
    Route::get('/stroies/list',  [StoryController::class, 'storyApi'])->name('storyApi');
    Route::get('/single/stroies/{id}',  [StoryController::class, 'singleStroies'])->name('singleStroies');
    Route::get('/stroies/page/content',  [StoryController::class, 'pageContent'])->name('pageContent');
    
    #home pag
    Route::get('/home/page/content',  [HomePageController::class, 'homePagecontent'])->name('homePagecontent');
    Route::get('/home/page/review/content',  [HomePageController::class, 'homePageReviewcontent'])->name('homePageReviewcontent');
    Route::get('/home/page/partner/content',  [HomePageController::class, 'homePagePartner'])->name('homePagePartner');
    
    #about page
    Route::get('/about/page/content',  [AboutPageController::class, 'aboutPageContent'])->name('aboutPageContent');
    
    #Terms page
    Route::get('/terms/condition/list',  [FaqController::class, 'termsApi'])->name('termsApi');
    
    #global
     Route::get('/team/list',  [TeamController::class, 'teamList'])->name('teamList');
    
    Route::post('get-product', [FrontProductController::class, 'show']);
    Route::get('get-product-variation-data/{id}', [ProductVariationController::class, 'get_variation_data']);
    Route::get('get-color-variation-photos/{id}', [ProductVariationController::class, 'get_color_variation_photos']);
    Route::get('get-product-price/{id}', [PriceCalculatorController::class, 'calculate_price']);
    Route::post('get-child-product-details', [ChildProductController::class, 'show']);
    Route::get('product-discount/{price}/{type}/{amount}/{time?}', [PriceCalculator::class, 'discount_price_calculate']);

    Route::post('get-recommended-product-right', [FrontProductController::class, 'get_recommended_product_right']);
    Route::post('get-recommended-product', [FrontProductController::class, 'all_recommended_products']);
   
    Route::post('get-category-product', [FrontProductController::class, 'get_category_product']);
    Route::post('get-category-filter-data/{slug_id}', [FrontProductController::class, 'get_category_filter_data']);
    Route::post('get-banner', [FrontendBannerController::class, 'get_banner']);
    Route::post('get-slider', [FrontendSliderController::class, 'get_slider']);
    Route::post('get-tag-products', [FrontProductController::class, 'get_tag_products']);
    Route::post('get-best-selling-product', [FrontProductController::class, 'get_best_selling_product']);
    Route::get('get-best-selling-products', [FrontProductController::class, 'get_best_selling_products']);
    Route::post('get-brands', [FrontendBrandController::class, 'get_brands']);
    Route::get('get-brand-list', [FrontendBrandController::class, 'get_brand_list']);
    Route::get('get-brand-details/{slug_id}', [FrontendBrandController::class, 'get_brand_details']);

    Route::get('test-brand/{slug_id}', [FrontendBrandController::class, 'calculate_brand_product_sold']);

    Route::get('get-brand-products/{slug_id}', [FrontendBrandController::class, 'get_brand_products']);

    Route::post('get-hot-categories', [FrontEndCategoryController::class, 'get_hot_categories']);
    Route::post('get-latest-products', [FrontProductController::class, 'get_latest_products']);
    Route::post('get-latest-global-products-for-mobile', [FrontProductController::class, 'get_global_product_for_mobile_index']);
    Route::post('get-latest-products-for-home-page', [FrontProductController::class, 'get_latest_products_for_home_page']);
    Route::post('get-global-category', [FrontEndCategoryController::class, 'get_global_category']);
    Route::get('get-menu-categories', [FrontEndCategoryController::class, 'get_menu_categories']);
    Route::get('get-all-categories', [FrontEndCategoryController::class, 'get_all_categories']);
    Route::get('get-sub-categories/{slug_id}', [FrontEndCategoryController::class, 'get_sub_categories']);
    Route::post('get-new-arrival-products', [FrontProductController::class, 'get_new_arrival_products']);
    Route::post('get-flash-deal-products', [FrontProductController::class, 'get_flash_deal_products']);


    Route::post('product-review-replay', [ReviewReplayController::class, 'store']);
    Route::post('search', [FrontProductController::class, 'search']);
    Route::post('search-result/{product_name}/{product_id?}', [FrontProductController::class, 'search_result']);


    //grocery section
    Route::post('get-grocery-category', [GroceryController::class, 'get_grocery_category']);
    Route::post('get-grocery-products', [GroceryController::class, 'get_grocery_products']);
    Route::post('get-modal-product', [GroceryController::class, 'get_modal_product']);
    Route::post('get-grocery-product-details', [GroceryController::class, 'get_grocery_product_details']);
    Route::post('get-grocery-category-products', [GroceryController::class, 'index']);

    //global section

    Route::get('get-global-categories', [FrontEndCategoryController::class, 'get_global_categories']);
    Route::get('get-global-products', [GlobalProductController::class, 'index']);
    Route::get('get-global-products-for-index', [GlobalProductController::class, 'get_global_products_for_index']);



    Route::post('category-bread-crumb', [FrontEndCategoryController::class, 'category_bread_crumb']);
    Route::post('get-related-category/{slug_id}', [FrontEndCategoryController::class, 'get_related_category']);

    //review
    Route::get('get-product-review/{slug_id}', [FrontendReviewController::class, 'index']);



    Route::get('test', [FrontEndCategoryController::class, 'test']);



   
    Route::get('get-popular-blog-list', [FrontendBlogController::class , 'index']);
    Route::get('get-blog-details/{slug_id}', [FrontendBlogController::class , 'show']);

    Route::get('get-page-content/{id}', [FrontendPageContent::class, 'index']);


    Route::post('contact-us', [ContactUsController::class, 'store']);
    Route::post('news-letter-subscription', [FrontendNewsLetterController::class, 'store']);

    Route::get('get-store-data/{id}', [StoreController::class, 'get_store_data']);
    Route::get('get-store-products/{id}', [StoreController::class, 'get_store_product']);
    Route::get('get-store-feature-products/{id}', [StoreController::class, 'get_store_feature_product']);
    Route::get('get-store-new-arrival-products/{id}', [StoreController::class, 'get_store_new_arrival_product']);
    Route::get('get-store-new-products/{id}', [StoreController::class, 'get_store_new_product']);
    
    Route::get('global/setting', [SettingsController::class, 'settingApi']);
    
    
    Route::post('get-grocery-category-for-products-page', [GroceryController::class, 'get_grocery_category_for_products_page']);

    //customers auth section
});

Route::group(['prefix' => 'frontend', 'middleware' => 'auth:customers'], function () {
    
   
    
    Route::get('store-follow-unfollow/{id}', [StoreController::class, 'store_follow_unfollow']);
    Route::get('store-like-unlike/{id}', [StoreLikeController::class, 'store_like_unlike']);

    Route::get('auth-get-store-details/{id}', [StoreController::class, 'store_details']);


    Route::get('auth-get-store-data/{id}', [StoreController::class, 'get_store_data']);

    Route::post('customer/logout',[CustomerAuthController::class, 'customerLogout']);
    Route::post("check-auth",[CustomerAuthController::class,'check_auth']);

    
    
    Route::get('get-cart-items-count', [CartController::class, 'cart_items_count']);
    
    Route::post('get-cart-product-variations/{id}', [CartController::class, 'get_cart_product_variations']);
    Route::post('update-cart-attributes', [CartController::class, 'update_cart_attributes']);
    Route::post('handle-cart-select/{id}', [CartController::class, 'handle_cart_select']);
    Route::post('handle-cart-all-select', [CartController::class, 'handle_cart_all_select']);
    

    Route::get('get-grocery-cart-items', [GroceryCartController::class, 'index']);
    Route::post('update-grocery-cart-quantity', [GroceryCartController::class, 'update_grocery_cart_quantity']);
    Route::get('get-grocery-cart-total', [GroceryCartController::class, 'get_grocery_cart_total']);
    Route::delete('remove-item-from-grocery-cart/{id}', [GroceryCartController::class, 'remove_item_from_grocery_cart']);

   // Route::post('get-grocery-category-for-products-page', [GroceryController::class, 'get_grocery_category_for_products_page']);

    Route::post('save-address', [BackendAddressController::class, 'store']);
    Route::put('update-address/{id}', [BackendAddressController::class, 'update']);
    Route::get('get-customer-address', [FrontCustomerAddressController::class, 'get_customer_address']);
    Route::get('get-delivery-charge/{id}', [DeliveryChargeController::class, 'get_delivery_charge']);
    Route::post('make-default-address/{id}', [AddressController::class, 'make_default_address']);
    Route::get('get-address-for-edit/{id}', [AddressController::class, 'get_address_for_edit']);
    //order
    Route::post('grocery-place-order', [GroceryOrderController::class, 'store']);
    // Route::post('place-order', [OrderController::class, 'store']);

    // Route::post('procced-to-discount', [BuyNowController::class, 'porccedDiscount']);
    // Route::post('procced-to-buy-new-payment', [BuyNowController::class, 'porccedToBuyNowPayment']);
    // Route::post('get-buy-now-items', [BuyNowController::class, 'get_buy_now_items']);
    // Route::post('place-buy-now-order', [BuyNowController::class, 'buyNowOrderPlace']);

    // Route::get('get-my-order', [OrderController::class, 'index']);
    Route::get('get-my-order-details/{id}', [OrderController::class, 'show']);
     Route::get('get-my-order-amount', [OrderController::class, 'totalOrderAmount']);
    Route::get('global-order-list', [OrderController::class, 'global_order_list']);

    Route::get('get-cart-count', [CartController::class, 'global_order_list']);

    Route::apiResource('coupon', FrontendCouponController::class);

    Route::get('update-brand-like/{slug_id}', [FrontendBrandController::class, 'update_brand_like']);


    Route::get('get-my-transaction', [TransactionController::class, 'get_my_transaction']);

    Route::get('get-payment-method-for-wallet', [PaymentMethodController::class, 'get_payment_method_for_wallet']);



    //review section
    Route::post('product-review-post', [FrontEndReviewController::class , 'store']);

    Route::get('get-products-for-review', [FrontEndReviewController::class , 'get_products_for_review']);
    Route::get('get-my-reviewed-product', [FrontEndReviewController::class , 'get_my_reviewed_product']);



    //wishlist
    Route::post('add-to-wishlist', [FrontendWishListController::class , 'store']);


    Route::post('get-auth-wishlist-details', [FrontendWishListController::class , 'get_wishlist_details']);
    Route::get('get-my-wishlist', [FrontendWishListController::class , 'get_my_wishlist']);
    Route::delete('delete-wishlist-item/{id}', [FrontendWishListController::class , 'destroy']);

    Route::apiResource('my-profile', ProfileController::class);

    
    Route::get("get-wallet-transactions",[FrontendTransactionController::class,'index']);
    Route::apiResource("ticket", FrontendTicketController::class);

    Route::get('auth-get-brand-details/{slug_id}', [FrontendBrandController::class, 'get_brand_details']);

});

Route::group(['prefix' => 'frontend'], function () {
      // Customer profile section
//    Route::post("customer-data/{id}",[CustomerAuthController::class,'CustomerProfileData']);

    Route::get('get-cities', [FrontCustomerAddressController::class, 'get_cities']);
    Route::get('get-zones/{id}', [FrontCustomerAddressController::class, 'get_zones']);
    Route::get('get-areas/{id}', [FrontCustomerAddressController::class, 'get_areas']);
    
});


Route::group([ 'middleware' => 'auth:customers'], function () {
    
    Route::get('get-my-order', [OrderController::class, 'index']);
    Route::get('get-my-active-package', [OrderController::class, 'getMyActivePackage']);
    
    Route::get('get-total-amount', [OrderController::class, 'totalOrderAmount']);
    Route::get('get-cart-summary', [CartController::class, 'get_cart_summary']);
    Route::get('subcraption-get-cart-summary', [CartController::class, 'subcraption_get_cart_summary']);
    
    // login register section
    Route::post('customer/validation',[CustomerAuthController::class, 'CustValidation']);
    Route::post("check-auth",[CustomerAuthController::class,'check_auth']);
    Route::post('customer/forget-password',[CustomerAuthController::class, 'forgetPassword']);
    Route::post('customer/reset-password',[CustomerAuthController::class, 'resetPassword']);
    Route::post('add-to-cart', [CustomerAuthController::class, 'addTOCart']);
    Route::post("customer-data/{id}",[CustomerAuthController::class,'CustomerProfileData']);
    Route::get("customer_data",[CustomerAuthController::class,'CustomerProfileDataAfterLogin']);
    Route::get("customer-data-address",[CustomerAuthController::class,'CustomerAddressData']);
    Route::get("customer-data-billing-information",[CustomerAuthController::class,'CustomerBillingInformation']);
    Route::post("customer-data-update",[CustomerAuthController::class,'updateCustomerInformation']);
    Route::post("customer-password-data-update",[CustomerAuthController::class,'customerPasswordUpdate']);
    
     Route::post("customer-billing-data-update",[CustomerAuthController::class,'customerBillingDataUpdate']);
    Route::get('get-cart-items', [CartController::class, 'index']);
    
    Route::get('get-cart-items-count', [CartController::class, 'cart_items_count']);
    Route::get('get-cart-count', [CartController::class, 'global_order_list']);
    Route::get('remove-product-from-order', [OrderProductController::class, 'destroy']);
    Route::get('remove-product-from-cart', [OrderProductController::class, 'cartDestory']);
    
    Route::post('place-order', [OrderController::class, 'store']);
    Route::post('subscription-place-order', [OrderController::class, 'subcriptionPlaceOrder']);
    
    Route::post('update-cart-quantity/{id}', [CartController::class, 'update']);
    Route::post('delete-cart-item/{id}', [CartController::class, 'destroy']);
    
    Route::post('subcraption-reqeust', [CustomerAuthController::class, 'subcraptionReqeust']);
    
});  

Route::post('/test-variation', [GenerateVariationController::class, 'test']);
