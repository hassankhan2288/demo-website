<?php

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Mail\CaterMail;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

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

Route::get('/insertCategoryProduct', 'Admin\AccountController@insertIntoCategoryProduct');


Route::get('/pos-reset-password', 'Pos\ResetController@posresetForm')->name('pos.reset.branch.password');
Route::post('/pos-reset-password-link', 'Pos\ResetController@posresetLink')->name('pos.reset.link');
Route::get('/pos-reset-password/{token}', function (string $token) {
    return view('auth.passwords.reset', ['token' => $token]);
})->name('forgot-password-link');
Route::post('pos-reset-password-save', 'Pos\ResetController@posResetPassUser')->name('pos.reset.password');


/************** FrontEnd ***********************/

Route::get('/','Front\HomeController@index')->name('home');
Route::get('/mobile/checkout/{id}','OrderController@checkout');
//Route::get('/promotions','Front\HomeController@promotion')->name('promotions');
Route::get('/promotions','Front\FrontendController@productPromotionsGrids')->name('promotions');
Route::get('/aboutus','Front\HomeController@aboutus')->name('aboutus');
Route::get('/contact','Front\HomeController@contact')->name('contact');
Route::get('/careers','Front\HomeController@careers')->name('careers');
Route::get('/gallery','Front\HomeController@gallery')->name('gallery');
//Route::get('/products','Front\HomeController@products');
Route::get('/click-collect','Front\HomeController@click')->name('click');
Route::get('/products','Front\FrontendController@productGrids')->name('product-grids');

Route::get('/design/{slug}','Front\FrontendController@design')->name('design');
Route::get('/preference/{preference}','Front\FrontendController@preferenceChange')->name('preferece');
Route::get('/product-lists','Front\FrontendController@productLists')->name('product-lists');
Route::match(['get','post'],'/filter','Front\FrontendController@productFilter')->name('shop.filter');
Route::get('/product-brand/{slug}','Front\FrontendController@productBrand')->name('product-brand');
Route::get('product-detail/{slug}','Front\FrontendController@productDetail')->name('product-detail');
Route::get('/product/search','Front\FrontendController@productSearch')->name('product.search.frontend');
Route::get('/product/autocomplete','Front\FrontendController@autocomplete')->name('product.autocomplete');
Route::get('/product-cat/{slug}','Front\FrontendController@productCat')->name('product-cat');
Route::get('/product-sub-cat/{slug}/{sub_slug}','Front\FrontendController@productSubCat')->name('product-sub-cat');
Route::get('/add-to-cart/{slug}','Front\CartController@addToCart')->name('add-to-cart');
Route::post('/add-to-cart','Front\CartController@singleAddToCart')->name('single-add-to-cart');
Route::get('cart-delete/{id}','Front\CartController@cartDelete')->name('cart-delete');
Route::post('cart-update','Front\CartController@cartUpdate')->name('cart.update');
Route::post('/subscribe','Front\FrontendController@subscribe')->name('subscribe');
Route::post('/contact/form','Front\FrontendController@contact_form')->name('contact_form');
Route::get('/cart',function(){
    return view('frontend.cart');
})->name('cart');
Route::get('/thankYou',function(){
    return view('frontend.thankYou');
})->name('thankYou');

Route::get('/checkout','Front\CartController@checkout')->name('checkout');//->middleware('auth');

Route::post('/checkout/devlivery','Front\CartController@checkoutDevliveryStep2')->name('checkout.delivery');//->middleware('auth');

//Route::get('/checkout/payment', 'Front\FrontendController@mypayment')->name('checkingpayment');
Route::get('/checkout/payment', 'Front\FrontendController@paymentScreen')->name('payment');

Route::post('cart/order','Front\OrderController@store')->name('cart.order');
Route::get('/cart/update/ajax', 'Front\CartController@ajaxUpdate')->name('cart.ajax');
// Wishlist
Route::get('/wishlist',function(){
    return view('frontend.wishlist');
})->name('wishlist');
Route::get('/wishlist/{slug}','Front\WishlistController@wishlist')->name('add-to-wishlist');
Route::get('wishlist-delete/{id}','Front\WishlistController@wishlistDelete')->name('wishlist-delete');

Route::post('reset-user-pass','Front\AccountController@resetPassUser')->name('reset.password.post');
Route::get('/reset-password', 'Front\AccountController@resetForm')->name('reset-user-password');
Route::post('/reset-password-link', 'Front\AccountController@resetLink')->name('reset.link');
Route::get('/reset-password/{token}', function (string $token) {
    return view('frontend.resetPasswordForm', ['token' => $token]);
})->name('password.reset');




/************ End frontend ******************/

/************** App ***********************/
Route::prefix('company')->group(function () {

    Route::get('/', 'App\DashboardController@index');
    Route::get('/dashboard', 'App\DashboardController@index')->name('app.dashboard');

    /** Branch **/
    Route::get('/branch', 'App\BranchController@index')->name('app.branch');
    Route::get('/branch/add/{id?}', 'App\BranchController@form')->name('app.branch.form');
    Route::post('/branch/submit', 'App\BranchController@submit')->name('app.branch.submit');
    Route::post('/branch/ajax', 'App\BranchController@ajax')->name('app.branch.ajax');
    Route::get('/branch/assign/{id}', 'App\BranchController@assign')->name('app.branch.assign');

    /** Product **/
    Route::get('/product', 'App\ProductController@index')->name('app.product');
    Route::post('product/ajax/branch', 'App\ProductController@ajax')->name('app.product.ajax.branch');
    Route::get('products/app/search', 'App\ProductController@adminProductSearch')->name('app.product.search');
    Route::post('products/app/search', 'App\ProductController@assignProduct')->name('app.product.assign');
    Route::post('product/ajax', 'App\BranchController@branchProductAjax')->name('app.branch.product.ajax');
    Route::post('products/app/update-price', 'App\ProductController@updatePrice')->name('app.product.update.price');

    /** Sale **/
    Route::get('sales/sale-list', 'App\SaleController@index')->name('app.sale.list');
    Route::post('sales/sale-data', 'App\SaleController@saleData')->name('app.sale.data');
    Route::get('sales/status/{id}/{slug}', 'App\SaleController@saleStatus')->name('app.sale.status');
    /** Report **/
    Route::get('/report', 'App\ReportController@index')->name('app.report');
    Route::get('/report/{id}', 'App\ReportController@invoice')->name('app.report.invoice');
    Route::post('/report/ajax', 'App\ReportController@ajax')->name('app.report.ajax');
    Route::get('/report/search/branch', 'App\ReportController@searchBranch')->name('app.report.search.branch');
    /*Push to dynamics */
    


    Route::resource('customers_category', 'App\CustomerCategoryController');
        Route::post('customers_category/import', 'App\CustomerCategoryController@import')->name('customers_category.imports');
        Route::post('customers_category/deletebyselection', 'App\CustomerCategoryController@deleteBySelection');
        Route::post('customers_category/category-data', 'App\CustomerCategoryController@categoryData');

        Route::post('products/company/update-cate', 'App\ProductController@updateCate')->name('company.product.update.cate');



    /** Login **/
    Route::get('/login', 'Auth\LoginController@showAppLoginForm')->name('app.login');
    Route::post('/login', 'Auth\LoginController@appLogin')->name('app.post.login');
    Route::get('/logout', 'App\AccountController@logoutApp')->name('app.logout');



});
/******************** End App *****************/

/************** POS ***********************/
Route::prefix('branch')->group(function () {

    Route::get('/', 'Pos\DashboardController@index');
    Route::get('/dashboard', 'Pos\DashboardController@index')->name('pos.dashboard');


    /** Account **/
    Route::prefix('account')->group(function () {
        Route::get('/settings', 'Pos\AccountController@index')->name('pos.account.settings');
        Route::post('/save-settings', 'Pos\AccountController@saveSettings')->name('pos.account.save.settings');
    });
    /** Reset Password **/

    // Route::post('pos-reset-pass','Pos\ResetController@resetPassUser')->name('pos.reset.password');
    // Route::get('/pos-reset-password', 'Pos\ResetController@resetForm')->name('pos.reset-user-password');
    // Route::post('/reset-password-link', 'Pos\ResetController@resetLink')->name('pos.reset.link');
    // Route::get('/reset-password/{token}', function (string $token) {
    //     return view('auth.passwords.reset', ['token' => $token]);
    // })->name('password.reset');
   

    /*** product **/

    Route::get('product', 'Pos\ProductController@index')->name('pos.product');
    Route::post('product/ajax/pos', 'Pos\ProductController@ajax')->name('app.product.ajax.pos');
    Route::post('product/add-favorite', 'Pos\ProductController@addFavorite')->name('pos.product.add.favorite');

    Route::get('pos/print-last-reciept', 'Pos\SaleController@printLastReciept')->name('sales.printLastReciept');

    /** Sale **/

    Route::POST('check-s3-image', 'Pos\SaleController@checkS3Image')->name('amazon.s3');

    Route::get('sales/sale-list', 'Pos\SaleController@index')->name('pos.sale.list');
    Route::post('sales/sale-data', 'Pos\SaleController@saleData')->name('pos.sale.data');
    Route::get('pos', 'Pos\SaleController@posSale')->name('pos.sale.pos');
    Route::post('pos', 'Pos\SaleController@store')->name('pos.sales.store');
    Route::get('sales/getproduct', 'Pos\SaleController@getProduct')->name('pos.sale.getproduct');
    Route::get('sales/lims_product_search', 'Pos\SaleController@limsProductSearch')->name('pos.product_sale.search');
    Route::get('sales/gen_invoice/{id}', 'Pos\SaleController@genInvoice')->name('pos.sale.invoice');
    Route::post('sales/sendmail', 'Pos\SaleController@sendMail')->name('pos.sale.sendmail');
    Route::get('sales/pos-product-list', 'Pos\SaleController@posProductList')->name('pos.product.list');
    Route::post('sales/pos-sale-submit', 'Pos\SaleController@posSaleSubmit')->name('pos.sale.submit');
    Route::post('sales/get-product-by-order', 'Pos\SaleController@getProductByOrder')->name('pos.order.by.product');
    Route::get('sales/status/{id}/{slug}', 'Pos\SaleController@saleStatus')->name('pos.sale.status');



    /** Report **/
    Route::get('/report', 'Pos\ReportController@index')->name('pos.report');
    Route::get('/report/{id}', 'Pos\ReportController@invoice')->name('pos.report.invoice');
    Route::post('/report/ajax', 'Pos\ReportController@ajax')->name('pos.report.ajax');

    /** Auth **/

    Route::get('/login', 'Auth\BranchLoginController@showPosLoginForm')->name('pos.login');
    Route::post('/login', 'Auth\BranchLoginController@posLogin')->name('pos.post.login');
    Route::get('/logout', 'Pos\AccountController@logoutBranch')->name('pos.logout');

});
/************* End Pos *******************/

Route::prefix('app/account')->group(function () {
    Route::get('/settings', 'App\AccountController@index')->name('account.settings');
    Route::post('/save-settings', 'App\AccountController@saveSettings')->name('account.save.settings');
});

/***************** Admin *******************/
Route::prefix('admin')->group(function () {
    Route::get('/company/priceupdate/{id}', 'Admin\CompanyAddPrice@GetCompanyPricing')->name('companyprice.update');
    
    Route::get('/deliveryroute/index', 'Admin\DeliveryWeek@index')->name('deliveryr.index');
    Route::get('/deliveryroute/create', 'Admin\DeliveryWeek@create');
    Route::post('/deliveryroute/store', 'Admin\DeliveryWeek@store')->name('deliveryroute.store');
    Route::get('/deliveryroute/edit/{id}', 'Admin\DeliveryWeek@edit')->name('deliveryroute.edit');
    Route::post('/deliveryroute/update/{id}', 'Admin\DeliveryWeek@update')->name('deliveryroute.update');
    Route::get('/deliveryroute/delete/{id}', 'Admin\DeliveryWeek@delete')->name('deliveryroute.delete');


    Route::get('/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');

    Route::get('company_view/{id}', 'Admin\DashboardController@companyIndex')->name('admin.dashboard.company');

    /** Category **/
    Route::post('category/import', 'Admin\CategoryController@import')->name('category.import');
    Route::post('category/deletebyselection', 'Admin\CategoryController@deleteBySelection');
    Route::post('category/category-data', 'Admin\CategoryController@categoryData');
    Route::resource('category', 'Admin\CategoryController');
    Route::resource('customer_category', 'Admin\CustomerCategoryController');
    Route::post('customer_category/import', 'Admin\CustomerCategoryController@import')->name('customer_category.import');
    Route::post('customer_category/deletebyselection', 'Admin\CustomerCategoryController@deleteBySelection');
    Route::post('customer_category/category-data', 'Admin\CustomerCategoryController@categoryData');

    /** Brand **/
    Route::post('importbrand', 'Admin\BrandController@importBrand')->name('brand.import');
    Route::post('brand/deletebyselection', 'Admin\BrandController@deleteBySelection');
    Route::get('brand/lims_brand_search', 'Admin\BrandController@limsBrandSearch')->name('brand.search');
    Route::resource('brand', 'Admin\BrandController');

    /** Tax **/
    Route::get('/tax', 'Admin\TaxController@index')->name('admin.tax');
    Route::get('/tax/add/{id?}', 'Admin\TaxController@form')->name('admin.tax.form');
    Route::post('/tax/submit', 'Admin\TaxController@submit')->name('admin.tax.submit');
    Route::post('/tax/ajax', 'Admin\TaxController@ajax')->name('admin.tax.ajax');
    Route::get('/tax/delete/{id}', 'Admin\TaxController@taxDelete')->name('admin.tax.deleted');


    /** Coupon **/
    Route::get('/coupon', 'Admin\CouponController@index')->name('admin.coupon');
    Route::get('/coupon/add/{id?}', 'Admin\CouponController@form')->name('admin.coupon.form');
    Route::post('/coupon/submit', 'Admin\CouponController@submit')->name('admin.coupon.submit');
    Route::post('/coupon/ajax', 'Admin\CouponController@ajax')->name('admin.coupon.ajax');
    Route::get('/coupon/delete/{id}', 'Admin\CouponController@couponDelete')->name('admin.coupon.deleted');

    /** Product Price Table **/
    Route::get('/product_price', 'Admin\ProductPriceController@index')->name('admin.product_price');
    Route::get('/product_price/add/{id?}', 'Admin\ProductPriceController@form')->name('admin.product_price.form');
    Route::post('/product_price/submit', 'Admin\ProductPriceController@submit')->name('admin.product_price.submit');
    Route::post('/product_price/ajax', 'Admin\ProductPriceController@ajax')->name('admin.product_price.ajax');
    Route::get('/product_price/delete/{id}', 'Admin\ProductPriceController@productPriceDelete')->name('admin.product_price.deleted');
    
    /** Company Pricing **/
    Route::get('/company_pricing', 'Admin\CompanyController@CompanyPricingIndex')->name('admin.company_pricing');
    Route::get('/company_pricing/add/{id?}', 'Admin\CompanyController@CompanyPricingForm')->name('admin.company_pricing.form');
    Route::post('/company_pricing/submit', 'Admin\CompanyController@CompanyPricingSubmit')->name('admin.company_pricing.submit');
    Route::post('/company_pricing/ajax', 'Admin\CompanyController@CompanyPricingAjax')->name('admin.company_pricing.ajax');
    Route::get('/company_pricing/delete/{id}', 'Admin\CompanyController@CompanyPricingDelete')->name('admin.company_pricing.deleted');

    /** Search Term **/
    Route::get('/search_term', 'Admin\ProductPriceController@searchTermIndex')->name('admin.search_term');
    Route::get('/search_term/add/{id?}', 'Admin\ProductPriceController@searchTermForm')->name('admin.search_term.form');
    Route::post('/search_term/submit', 'Admin\ProductPriceController@searchTermSubmit')->name('admin.search_term.submit');
    Route::post('/search_term/ajax', 'Admin\ProductPriceController@searchTermAjax')->name('admin.search_term.ajax');
    Route::get('/search_term/delete/{id}', 'Admin\ProductPriceController@searchTermDelete')->name('admin.search_term.deleted');

    /** Product **/
    Route::post('products/product-data', 'Admin\ProductController@productData')->name('admin.products');
    Route::get('products/gencode', 'Admin\ProductController@generateCode');
    Route::get('products/search', 'Admin\ProductController@search');
    Route::get('products/saleunit/{id}', 'Admin\ProductController@saleUnit');
    Route::get('products/getdata/{id}/{variant_id}', 'Admin\ProductController@getData');
    Route::get('products/product_warehouse/{id}', 'Admin\ProductController@productWarehouseData');
    Route::post('importproduct', 'Admin\ProductController@importProduct')->name('product.import');
    Route::post('exportproduct', 'Admin\ProductController@exportProduct')->name('product.export');
    Route::get('products/print_barcode','Admin\ProductController@printBarcode')->name('product.printBarcode');
    Route::get('products/lims_product_search', 'Admin\ProductController@limsProductSearch')->name('product.search');
    Route::post('products/deletebyselection', 'Admin\ProductController@deleteBySelection');
    Route::post('products/update', 'Admin\ProductController@updateProduct');
    Route::get('products/variant-data/{id}','Admin\ProductController@variantData');
    Route::get('products/history', 'Admin\ProductController@history')->name('products.history');
    Route::post('products/sale-history-data', 'Admin\ProductController@saleHistoryData');
    Route::post('products/purchase-history-data', 'Admin\ProductController@purchaseHistoryData');
    Route::post('products/sale-return-history-data', 'Admin\ProductController@saleReturnHistoryData');
    Route::post('products/purchase-return-history-data', 'Admin\ProductController@purchaseReturnHistoryData');
    Route::get('products/admin/search', 'Admin\ProductController@adminProductSearch')->name('admin.product.search');
    Route::post('products/admin/assign', 'Admin\ProductController@assignProduct')->name('admin.product.assign');
    Route::post('products/admin/update-price', 'Admin\ProductController@updatePrice')->name('admin.product.update.price');
    Route::post('products/admin/update-price-branch', 'Admin\ProductController@updatePriceB')->name('admin.product.update.price.branch');
    Route::post('products/admin/update-cate', 'Admin\ProductController@updateCate')->name('admin.product.update.cate');
    Route::resource('products', 'Admin\ProductController');

    Route::get('products/assign/free-products/{id}' , 'Admin\ProductController@assginFreeProducts')->name('admin.product.assign.free.product');
    Route::post('/product/free/ajax', 'Admin\ProductController@freeProductAssignAjax')->name('admin.assign.free.product.ajax');
    Route::post('/product/free/ajax/assigned', 'Admin\ProductController@freeProductAjaxAssigned')->name('admin.free.product.ajax.assigned');
    Route::post('product/free/assigned', 'Admin\ProductController@assignedFreeProducts')->name('admin.free.product.assigned');
    Route::get('/product/free/unassigned', 'Admin\ProductController@unassginFreeProducts')->name('admin.free.product.unassigned');


    /** User */
    Route::get('/user', 'Admin\UserController@index')->name('admin.user');
    Route::get('/user/add/{id?}', 'Admin\UserController@form')->name('admin.user.form');
    Route::post('/user/submit', 'Admin\UserController@submit')->name('admin.user.submit');
    Route::post('/user/ajax', 'Admin\UserController@ajax')->name('admin.user.ajax');
    /** Company **/
    Route::get('/company', 'Admin\CompanyController@index')->name('admin.company');
    Route::get('/company/add/{id?}', 'Admin\CompanyController@form')->name('admin.company.form');
    Route::post('/company/submit', 'Admin\CompanyController@submit')->name('admin.company.submit');
    Route::post('/company/ajax', 'Admin\CompanyController@ajax')->name('admin.company.ajax');

    Route::get('/company/assign/{id}', 'Admin\CompanyController@assign')->name('admin.company.assign');
    Route::post('/company/product/ajax', 'Admin\CompanyController@companyProductAjax')->name('admin.company.product.ajax');
    Route::post('/company/product/ajax/assigned', 'Admin\CompanyController@companyProductAjaxAssigned')->name('admin.company.product.ajax.assigned');

    Route::post('/company/product/assign', 'Admin\CompanyController@companyProductAssign')->name('admin.company.product.assign');
    Route::get('/company/product/deleted' , 'Admin\CompanyController@deleteAssignedProduct')->name('admin.company.product.delete');
    Route::post('company/updateDeliveryDate', 'Admin\CompanyController@updateDeliveryDate')->name('admin.update.deliveryDate');



    /** Campanny add Branch **/
    Route::get('/company/branch/{id}', 'Admin\CompanyController@branch')->name('admin.company.branch');
    Route::get('/company/branch/{id}/update/{slug}', 'Admin\CompanyController@branchUpdate')->name('admin.company.branch.update');
    Route::get('/company/branch/{id}/delete/{slug}', 'Admin\CompanyController@branchDelete')->name('admin.company.branch.delete');
    Route::post('/company/branch/ajax', 'Admin\CompanyController@branchAjax')->name('admin.company.branch.ajax');
    Route::post('/company/branch/ajax/branches', 'Admin\CompanyController@branchAjaxBranches')->name('admin.company.branch.ajax.branches');
    Route::post('/company/branch/submit', 'Admin\CompanyController@branchSubmit')->name('admin.company.branch.submit');
    Route::post('/company/branch/update', 'Admin\CompanyController@branchUpdated')->name('admin.company.branch.updated');
    Route::post('/company/update/branches', 'Admin\CompanyController@updateCompany')->name('admin.company.branches.update');
    /** admin */
    Route::get('/sub', 'Admin\AdminController@index')->name('admin.sub');
    Route::get('/sub/add/{id?}', 'Admin\AdminController@form')->name('admin.sub.form');
    Route::post('/sub/submit', 'Admin\AdminController@submit')->name('admin.sub.submit');
    Route::post('/sub/ajax', 'Admin\AdminController@ajax')->name('admin.sub.ajax');
    Route::get('/sub/delete/{id}', 'Admin\AdminController@deleteAdmin')->name('admin.sub.deleted');
    
    /** role */
    Route::get('/role', 'Admin\RoleController@index')->name('admin.role');
    Route::get('/role/add/{id?}', 'Admin\RoleController@form')->name('admin.role.form');
    Route::post('/role/submit', 'Admin\RoleController@submit')->name('admin.role.submit');
    Route::post('/role/ajax', 'Admin\RoleController@ajax')->name('admin.role.ajax');

    Route::prefix('account')->group(function () {
        Route::get('/settings', 'Admin\AccountController@index')->name('admin.account.settings');
        Route::post('/save-settings', 'Admin\AccountController@saveSettings')->name('admin.account.save.settings');
    });

    /** Promotion */
    Route::get('promotion', 'Admin\PromotionControler@index')->name('admin.promotion');
    Route::get('promotion/create', 'Admin\PromotionControler@create')->name('admin.promotion.create');
    Route::post('promotion/store', 'Admin\PromotionControler@store')->name('admin.promotion.store');
    Route::get('promotion/edit/{id}', 'Admin\PromotionControler@edit')->name('admin.promotion.edit');
    Route::post('promotion/edit/store/{id}', 'Admin\PromotionControler@promotion_store')->name('admin.promotion.edit.store');
    Route::delete('promotion/banner/delete/{id}', 'Admin\PromotionControler@promotion_delete')->name('admin.promotion.delete');

    /** Report **/
    Route::get('/report', 'Admin\ReportController@index')->name('admin.report');
    Route::get('/report/{id}', 'Admin\ReportController@invoice')->name('admin.report.invoice');
    Route::post('/report/ajax', 'Admin\ReportController@ajax')->name('admin.report.ajax');
    Route::get('/report/search/company', 'Admin\ReportController@searchCompany')->name('admin.report.search.company');
    Route::get('/report/search/branch', 'Admin\ReportController@searchBranch')->name('admin.report.search.branch');

    Route::get('/stock/search/product', 'Admin\StockController@searchProduct')->name('admin.stock.search.product');
    Route::get('/stock/search/warehouse', 'Admin\StockController@searchWarehouse')->name('admin.stock.search.warehouse');

    /** Sale **/
    Route::get('sales/sale-list', 'Admin\SaleController@index')->name('admin.sale.list');
    Route::get('sales/pos-sale-list', 'Admin\SaleController@posindex')->name('admin.pos.sale.list');
    Route::get('sales/sale-list/{id}', 'Admin\SaleController@index')->name('admin.sale.list.company');
    Route::post('sales/sale-data', 'Admin\SaleController@saleData')->name('admin.sale.data');
    Route::post('sales/pos-sale-data', 'Admin\SaleController@posSaleData')->name('admin.pos.sale.data');
    Route::get('pos', 'Admin\SaleController@posSale')->name('admin.sale.pos');
    Route::post('pos', 'Admin\SaleController@store')->name('admin.sales.store');
    Route::get('sales/getproduct', 'Admin\SaleController@getProduct')->name('admin.sale.getproduct');
    Route::get('sales/lims_product_search', 'Admin\SaleController@limsProductSearch')->name('admin.product_sale.search');
    Route::get('sales/gen_invoice/{id}', 'Admin\SaleController@genInvoice')->name('admin.sale.invoice');
    Route::get('sales/picklist/{id}', 'Admin\SaleController@picklist')->name('admin.sale.picklist');
    Route::get('sales/picklist/create/{id}', 'Admin\SaleController@picklistCreate')->name('admin.sale.picklist.create');
    Route::post('sales/picklist/save', 'Admin\SaleController@picklistSave')->name('admin.sale.picklist.save');
    Route::get('sales/picklist/delete/{id}/{sale_id}', 'Admin\SaleController@picklistDelete')->name('admin.sale.picklist.delete');
    Route::post('sales/picklist-data', 'Admin\SaleController@PicklistData')->name('admin.picklist.data');
    Route::post('sales/sendmail', 'Admin\SaleController@sendMail')->name('admin.sale.sendmail');
    Route::get('sales/pos-product-list', 'Admin\SaleController@posProductList')->name('admin.product.list');
    Route::post('sales/pos-sale-submit', 'Admin\SaleController@posSaleSubmit')->name('admin.sale.submit');
    Route::get('sales/status/{id}/{slug}', 'Admin\SaleController@saleStatus')->name('admin.sale.status');
    Route::post('sales/updateDeliveryDate', 'Admin\SaleController@updateDeliveryDate')->name('admin.update.deliveryDate');

    /** MS dynamic */
    Route::get('/microsoft-dynamic', 'Admin\MSDynamicController@index')->name('admin.ms.dynamic');
    Route::get('/push_order/{id}','Admin\MSDynamicController@pushDynamics')->name('admin.push.order.dynamics');
    Route::get('/pos/push_order/{id}','Admin\MSDynamicController@PosPushDynamics')->name('admin.pos.push.order.dynamics');
    Route::get('/push_user/{id}','Admin\MSDynamicController@pushDynamicsUser')->name('admin.push.user.dynamics');

    Route::resource('banner','Admin\BannerController');
    Route::resource('warehouse','Admin\WareHouseController');
    Route::resource('stock','Admin\StockController');
    Route::resource('branches','Admin\BranchesController');
    Route::resource('slots','Admin\SlotsController');
    Route::resource('leaves','Admin\LeavesController');
    Route::get('/login', 'Auth\AdminLoginController@showAdminLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@adminLogin')->name('admin.post.login');
    Route::get('/logout', 'Admin\AccountController@logoutAdmin')->name('admin.logout');

    /** Re-Order */
    Route::get('admin-pos/{order_id}/{user_id}/{branch_id}', 'Admin\SaleController@adminPosSale')->name('admin.pos.sale');
    Route::post('admin-sales/pos-sale-submit', 'Admin\SaleController@adminPosSaleSubmit')->name('admin.pos.sale.submit');
    Route::get('admin-sales/pos-product-list/{user_id}', 'Admin\SaleController@adminPosProductList')->name('admin.pos.product.list');
    Route::post('admin-sales/get-product-by-order', 'Admin\SaleController@adminGetProductByOrder')->name('admin.pos.order.by.product');
});
Route::post(
    'webhook',
    'WebhookController'
);
Route::post(
    'webhook/sale',
    'WebhookSaleController'
);
Route::get('slots_generater','Front\CartController@slots_generater')->name('slots_generater');
Route::get('ajax_cart','Front\CartController@ajax_cart')->name('ajax_cart');
Route::get('ajax_cartEmptyAndChangePreference','Front\CartController@emptyCartAndChangePreference')->name('ajax_cart_empty');

//Auth::routes(['verify' => true]);

    Route::get('customer/login', 'Auth\LoginController@showCustomerLoginForm')->name('customer.login');
    Route::post('customer/login', 'Auth\LoginController@customerLogin')->name('customer.post.login');
    Route::get('customer/logout', 'Front\AccountController@logoutCustomer')->name('customer.logout');
    Route::get('customer/register', 'Front\AccountController@showRegisterCustomerForm')->name('customer.register');
    Route::post('customer/register/post', 'Front\AccountController@RegisterCustomer')->name('customer.post.register');
    Route::get('customer/dashboard', 'Front\CustomerController@index')->name('customer.dashboard');//->middleware(['verified']);
    Route::get('customer/profile', 'Front\CustomerController@profile')->name('customer.profile');
    Route::get('customer/orders', 'Front\CustomerController@orders')->name('customer.orders');
    Route::get('customer/Order-Status/{id}', 'Front\CustomerController@Order_Status')->name('customer.Order_Status');

    // Route::get('/check/email',function(){
    //     $data = ['msg' => 'Your order has been recieved. Attached is the invoice in the email', 'name' => 'Ali'];

    //     Mail::to('hassanmateen2094@gmail.com')->send(new CaterMail($data,103));
    // });

    Route::get('/email/verify', function () {
        //return view('frontend.email_sent');
        return redirect('customer/login');
    })->name('verification.notice');

    Route::post('/email/verification-notification', function (Request $request) {
        // $request->user()->sendEmailVerificationNotification();
        $user = Customer::where('id',$request->user_id)->first();
        if($user){
            $user()->sendEmailVerificationNotification();
            return back()->with('message', 'Verification link sent!');
        }
        return back()->with('error', 'Error Sending mail');

    })->middleware(['throttle:6,1'])->name('verification.send');



    Route::get('/email/verify/{id}/{hash}', 'Front\AccountController@verifyCustomer')->middleware(['signed'])->name('verification.verify');

    Route::get('customer/Order-Cancel/{id}', 'Front\CustomerController@Order_Cancel')->name('customer.Order_Cancel');
    Route::post('customer/my-profile-update', 'Front\CustomerController@update')->name('customer.update');
    Route::post('customer/update-password', 'Front\CustomerController@updatepassword')->name('customer.updatepassword');
    //New Routes
    Route::post('customer/orders/ajax', 'Front\CustomerController@ajaxOrdersCustomer')->name('customer.order.table');
    Route::get('customer/report/{id}', 'Front\CustomerController@invoice');
    Route::get('/terms_and_condition', 'Front\FrontendController@termsAndCondition')->name('terms_and_condition');

    Route::get('/pdf_generate/{id}','Front\FrontendController@generateInvoicePDF')->name('generate.pdf.invoice');


Route::get('/run-prices-update', function(){
    Artisan::call('update:del_cc_prices');
    return true;
})->name('price-update');
// Route::post('/check/here','Api\ApiController@payment')->name('checker');
// Route::get('/run-prices-update', 'Api\ApiController@productPriceUpdate')->name('price-update');

Route::post(
    'payment/webhook',
    'PaymentWebhookController'
);
Route::post(
    'front/payment/webhook',
    'PaymentSenseWebhookController'
);

