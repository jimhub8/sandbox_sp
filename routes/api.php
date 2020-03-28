<?php

use Illuminate\Http\Request;

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
Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('login', 'Api\AuthController@login');
    // Route::post('signup', 'Api\AuthController@signup');
    // Route::get('signup/activate/{token}', 'Api\AuthController@signupActivate');
    Route::group([
        'middleware' => 'auth:api',
    ], function () {
        Route::get('logout', 'Api\AuthController@logout');
        Route::get('user', 'Api\AuthController@user');
    });
});
Route::resource('status', 'StatusController');


Route::group([
    'middleware' => 'auth:api',
], function () {
    // Route::resource('users', 'UserController');
    // Route::resource('roles', 'RoleController');
    Route::resource('shipment', 'Api\ShipmentController');
    // Route::resource('product', 'ProductController');
    // Route::resource('reports', 'ReportController');
    // Route::resource('container', 'ContainerController');
    // Route::resource('branches', 'Api\BranchController');
    // Route::resource('companies', 'CompanyController');
    // Route::resource('email', 'EmailController');
    // Route::resource('invoice', 'InvoiceController');

    Route::get('loggedin_user', 'Api\UserController@loggedin_user')->name('loggedin_user');
    Route::get('search/{order_no}', 'Api\ShipmentController@search')->name('search');

    Route::post('add_shipment', 'Api\ShipmentController@store');

	// Route::post('shopify_orders', 'Api\ShopifyController@shopify_orders')->name('shopify_orders');

    // Route::post('updateStatus/{id}', 'ShipmentController@updateStatus')->name('updateStatus');
    // Route::post('barcodeUpdate/{bar_code}', 'ShipmentController@barcodeUpdate')->name('barcodeUpdate');
    // Route::post('barcodeIn/{bar_code}', 'ShipmentController@barcodeIn')->name('barcodeIn');
    Route::get('additional', 'Api\ShipmentController@additional')->name('additional');
    // Route::post('getcoordinatesArray/{id}', 'ShipmentController@getcoordinatesArray')->name('getcoordinatesArray');
    // Route::patch('UpdateShipment', 'ShipmentController@UpdateShipment')->name('UpdateShipment');
    Route::post('filterShipment', 'ShipmentController@filterShipment')->name('filterShipment');

    // Route::post('AddShipments/{id}', 'ShipmentController@AddShipments')->name('AddShipments');
    // Route::post('conupdateStatus/{id}', 'ContainerController@conupdateStatus')->name('conupdateStatus');
    // Route::post('getShipmentArray/{id}', 'ContainerController@getShipmentArray')->name('getShipmentArray');
    // Route::post('assigndialog/{id}', 'ContainerController@assigndialog')->name('assigndialog');
    // Route::post('getContainers', 'ContainerController@getContainers')->name('getContainers');

    // Route::post('productAdd/{id}', 'ProductController@productAdd')->name('productAdd');
    // Route::post('getProducts', 'ProductController@getProducts')->name('getProducts');

    // Route::get('getUsers', 'UserController@getUsers')->name('getUsers');
    // Route::get('getDrivers', 'UserController@getDrivers')->name('getDrivers');
    // Route::get('getCustomer', 'UserController@getCustomer')->name('getCustomer');
    // Route::get('getLogedinUsers', 'UserController@getLogedinUsers')->name('getLogedinUsers');
    // Route::post('profile/{id}', 'UserController@profile')->name('profile');
    // Route::post('getSorted', 'UserController@getSorted')->name('getSorted');

    // Route::get('getUsersRole', 'RoleController@getUsersRole')->name('getUsersRole');
    // Route::get('getRoles', 'RoleController@getRoles')->name('getRoles');

    // Route::get('getBranch', 'BranchController@getBranch')->name('getBranch');

    // Route::post('getCompanies', 'CompanyController@getCompanies')->name('getCompanies');
    // Route::post('getCompanyAdmin', 'CompanyController@getCompanyAdmin')->name('getCompanyAdmin');
    // Route::post('companupdate/{id}', 'CompanyController@companupdate')->name('companupdate');
    // Route::post('logo/{id}', 'CompanyController@logo')->name('logo');
    // Route::post('getLogo', 'CompanyController@getLogo')->name('getLogo');
    // Route::post('getLogoOnly', 'CompanyController@getLogoOnly')->name('getLogoOnly');

    // Reports

    // Route::post('shipmentExpo', 'ReportController@shipmentExpo')->name('shipmentExpo');
    // Route::post('userExpo', 'ReportController@userExpo')->name('userExpo');
    // Route::post('ratesExpo', 'ReportController@ratesExpo')->name('ratesExpo');
    // Route::post('customersExpo', 'ReportController@customersExpo')->name('customersExpo');
    // Route::post('branchesExpo', 'ReportController@branchesExpo')->name('branchesExpo');
    // Route::post('agentsExpo', 'ReportController@agentsExpo')->name('agentsExpo');
    // Route::post('cancledExpo', 'ReportController@cancledExpo')->name('cancledExpo');
    // Route::post('pendingExpo', 'ReportController@pendingExpo')->name('pendingExpo');
    // Route::post('bookingExpo', 'ReportController@bookingExpo')->name('bookingExpo');
    // Route::post('approvedExpo', 'ReportController@approvedExpo')->name('approvedExpo');

    // Route::post('userDateExpo', 'ReportController@userDateExpo')->name('userDateExpo');

    // // Dashboard
    // Route::post('delayedShipment', 'ShipmentController@delayedShipment')->name('delayedShipment');
    // Route::post('approvedShipment', 'ShipmentController@approvedShipment')->name('approvedShipment');
    // Route::post('waitingShipment', 'ShipmentController@waitingShipment')->name('waitingShipment');
    // Route::post('deriveredShipment', 'ShipmentController@deriveredShipment')->name('deriveredShipment');

    // // Chart
    // Route::get('getChartData', 'ShipmentController@getChartData')->name('getChartData');

    // // E-MAILS
    // Route::post('/sendmail', 'EmailController@sendmail')->name('sendmail');
    // Route::post('/getsubscribers', 'EmailController@getsubscribers')->name('getsubscribers');
    // Route::post('/subscribe', 'EmailController@subscribe')->name('subscribe');
    // Route::post('/refresh/{id}', 'EmailController@refresh')->name('refresh');

    // Route::get('/slack', 'EmailController@slack');
    // Route::get('/slacks', 'EmailController@slacks');

    // Route::get('/getunsubscribed', 'EmailController@getunsubscribed')->name('getunsubscribed');

    // // Invoices
    // Route::get('/getInvoice', 'InvoiceController@getInvoice')->name('getInvoice');
    // Route::post('/getInvoiceSort', 'InvoiceController@getInvoiceSort')->name('getInvoiceSort');
    // Route::post('/sendMail', 'InvoiceController@sendMail')->name('sendMail');



	// Route::post('btwSTdate', 'Api\FilterController@btwSTdate')->name('btwSTdate');
	// Route::post('filterShipment', 'Api\FilterController@filterShipment')->name('filterShipment');
	// Route::post('filterCount', 'Api\FilterController@filterCount')->name('filterCount');
	// Route::post('getDeriveredS', 'Api\FilterController@getDeriveredS')->name('getDeriveredS');
	// Route::post('getOrdersS', 'Api\FilterController@getOrdersS')->name('getOrdersS');
	// Route::post('getreturned', 'Api\FilterController@getreturned')->name('getreturned');
	// Route::post('getPendingS', 'Api\FilterController@getPendingS')->name('getPendingS');
	// Route::post('filterPayment', 'Api\FilterController@filterPayment')->name('filterPayment');
	// Route::post('glSearch', 'Api\FilterController@glSearch')->name('glSearch');

});

//API Routes
// Route::post('shipment', 'Api\ShipmentController@store');
// Route::post('deleteShipment', 'Api\ShipmentController@delete');
// Route::post('trackShipment', 'Api\ShipmentController@track');
// Route::post('pincode', 'Api\ShipmentController@pincode');
// Route::post('pickup', 'Api\ShipmentController@createPickup');
// Route::post('deletePickup', 'Api\ShipmentController@deletePickup');
