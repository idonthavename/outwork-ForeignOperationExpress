<?php

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

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();

Route::group(['namespace' => 'Index'], function (){
    Route::get('/','IndexController@index');
    Route::get('/service','IndexController@service');
    Route::get('/charge','IndexController@charge');
    Route::get('/about','IndexController@about');
    Route::get('/news','IndexController@news');
    Route::get('/newsDetail/{id}','IndexController@newsDetail')->where('id','[0-9]+');
    Route::get('/expressResult/{no}','IndexController@expressResult');
    Route::get('/identification','IndexController@identification');
    Route::get('/tax','IndexController@identification');
    Route::post('/identification/do','IndexController@postIdentification')->name('goidentification');
    Route::post('/tax/do','IndexController@postIdentification')->name('gotax');
    Route::get('/tax/pay','IndexController@taxPay');
    Route::get('/payCallback','IndexController@payCallback')->name('payCallback');
    Route::post('/payNotify','IndexController@payNotify')->name('payNotify');
    Route::post('/webPayNotify','IndexController@payNotify')->name('webPayNotify');
    Route::get('/login','LoginController@show')->name('login');
    Route::post('/login/do','LoginController@login');

    Route::get('/register/one/{type}','RegisterController@stepOne')->where('type','personal|company');
    Route::post('/register/one/{type}/do','RegisterController@postStepOne')->where('type','personal|company');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/register/two/{type}','Index\RegisterController@stepTwo')->where('type','personal|company');
    Route::post('/register/two/{type}/do','Index\RegisterController@postStepTwo')->where('type','personal|company');

    Route::get('/register/three/{type}','Index\RegisterController@stepThree')->where('type','personal|company');
    Route::post('/register/three/{type}/do','Index\RegisterController@postStepThree')->where('type','personal|company');

    Route::get('/register/four/{type}','Index\RegisterController@stepFour')->where('type','personal|company');
    Route::post('/register/four/{type}/do','Index\RegisterController@postStepFour')->where('type','personal|company');

    Route::get('/register/five/{type}','Index\RegisterController@stepFive')->where('type','personal|company');
    Route::post('/register/five/{type}/do','Index\RegisterController@postStepFive')->where('type','personal|company');

    Route::get('/register/six/{type}','Index\RegisterController@stepSix')->where('type','personal|company');
    Route::post('/register/six/{type}/do','Index\RegisterController@postStepSix')->where('type','personal|company');

    Route::get('/register/two/{type}/sendEmail','Index\RegisterController@sendEmail')->where('type','personal|company');
});

Route::group(['prefix'=>'user','middleware'=>'auth','namespace' => 'Admin'],function () {
    Route::get('/','IndexController@index');
    Route::get('/center/{type}','CenterController@index')->where('type','1|2');
    Route::get('/center/{type}/get','CenterController@getData')->where('type','1|2');
    //未授权不能访问
    Route::group(['middleware'=>'adminActive'],function(){
        Route::get('/logout','IndexController@logout');
        Route::get('/reset','IndexController@reset');
        Route::post('/reset/do','IndexController@postReset');

        Route::get('/list/{status}','ListController@index')->where('status', '[0-9]');
        Route::get('/list/{status}/get','ListController@getData')->where('status', '[0-9]');
        Route::post('/list/userConfirmError','ListController@userConfirmError');
        Route::get('/list/showExpress','ListController@showExpress');

        Route::resource('/receiver', 'ReceiverController');
        Route::resource('/sender', 'SenderController');

        Route::get('/online','OnlineController@index');
        Route::get('/online/edit','OnlineController@edit');
        Route::get('/online/show','OnlineController@show');
        Route::post('/online/template','OnlineController@template');
        Route::post('/online/store','OnlineController@store');
        Route::post('/online/payedStore','OnlineController@payedStore');
        Route::post('/online/product-show','OnlineController@productShow');
        Route::post('/online/productDel','OnlineController@productDel');

        Route::post('/center/securepay','CenterController@securepay');
        Route::get('/center/showPay','CenterController@showPay');
        Route::get('/center/info','CenterController@showInfo');
        Route::post('/center/exchangeRate','CenterController@exchangeRate');

        Route::get('/orders','OrdersController@index');
        Route::post('/orders/upload','OrdersController@upload');
    });
});

Route::group(['prefix'=>'master','middleware'=>'checkMaster','namespace' => 'Master'],function () {
    Route::get('/','IndexController@index');

    Route::resource('/depot', 'DepotController');
    Route::resource('/addon', 'AddonController');
    Route::resource('/linetwo', 'LinetwoController');

    Route::get('/list/{status}','ListController@index')->where('status', '[0-9]');
    Route::get('/list/{status}/get','ListController@getData')->where('status', '[0-9]');
    Route::get('/list/audit','ListController@showAudit');
    Route::post('/list/audit','ListController@audit');
    Route::post('/list/pick','ListController@pick');
    Route::get('/list/weight','ListController@showWeight');
    Route::post('/list/weight','ListController@weight');
    Route::post('/list/charge','ListController@charge');
    Route::post('/list/getout','ListController@getout');
    Route::get('/list/change','ListController@showChange');
    Route::post('/list/change','ListController@change');
    Route::get('/list/changeUser','ListController@showChangeUser');
    Route::post('/list/changeUser','ListController@changeUser');
    Route::get('/list/productDetail/{system_order_no}','ListController@productDetail');
    Route::get('/list/orderlog/{oid}','ListController@orderlog')->where('oid','[0-9]+');
    Route::post('/list/excelExpress','ListController@excelExpress');
    Route::post('/list/outExcel','ListController@outExcel');
    Route::post('/list/downloadOrderPic','ListController@downloadOrderPic');

    Route::get('/user','UserController@index');
    Route::get('/user/get','UserController@getData');
    Route::get('/user/info','UserController@showInfo');
    Route::post('/user/active','UserController@active');
    Route::get('/user/changeRank','UserController@changeRank');
    Route::post('/user/changeRank','UserController@postChangeRank');
    Route::get('/user/resetPassword','UserController@resetPassword');
    Route::post('/user/resetPassword','UserController@postResetPassword');

    Route::resource('/product', 'ProductController');

    Route::resource('/line', 'LineController');
    Route::post('/line/excel', 'LineController@excel');

    Route::get('/center/{type}','CenterController@index')->where('type','1|2');
    Route::get('/center/{type}/get','CenterController@getData')->where('type','1|2');
    Route::get('/center/makeup','CenterController@makeup');
    Route::post('/center/makeup','CenterController@makeupAction');

    Route::get('/deduct','DeductController@index');
    Route::get('/deduct/get','DeductController@getData');
    Route::get('/deduct/import','DeductController@import');
    Route::post('/deduct/excelDeduct','DeductController@excelDeduct');

    Route::get('/print','PrintController@index');
    Route::get('/print/show','PrintController@show');
    Route::post('/print/show','PrintController@show');

    Route::resource('/content', 'ContentController');
});


Route::get('/home', 'HomeController@index')->name('home');
