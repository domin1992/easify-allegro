<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Front
Route::get('/', 'FrontController@index');
Route::get('/blog', 'FrontController@blog');
Route::get('/blog/{index}', 'FrontController@blogSingle');
Route::get('/jak-dziala', 'FrontController@howWorks');
Route::get('/kontakt', 'FrontController@getContact');
Route::post('/kontakt', 'FrontController@postContact');
Route::get('/phpinfo', 'FrontController@phpInfo');
Route::get('/polityka-prywatnosci', 'FrontController@privacyPolicy');
Route::get('/activate', 'FrontController@activateUser');
Route::get('/wyslij-link-aktywacyjny', 'FrontController@sendActivationalLink');
Route::get('/regulamin', function(){
  return view('front.regulations');
});

//Authentication
Route::get('/zaloguj', 'Auth\AuthController@getLogin');
Route::post('/zaloguj', 'Auth\AuthController@postLogin');
Route::get('/wyloguj', 'Auth\AuthController@getLogout');

Route::get('/rejestracja', 'Auth\AuthController@getRegister');
Route::post('/rejestracja', 'Auth\AuthController@postRegister');

//Password reset
Route::get('/resetuj-haslo', 'Auth\PasswordController@getEmail');
Route::post('/resetuj-haslo', 'Auth\PasswordController@postEmail');
Route::get('/nowe-haslo/{token}', 'Auth\PasswordController@getReset');
Route::post('/nowe-haslo', 'Auth\PasswordController@postReset');

//Panel
Route::get('/szablon', 'PanelController@template');
Route::get('/moje-szablony', 'PanelController@myTemplates');
Route::get('/nowy-szablon', 'PanelController@newTemplate');
Route::post('/nowy-szablon', 'PanelController@postNewTemplate');
Route::get('/moje-dokumenty', 'PanelController@myDocuments');
Route::get('/nowy-dokument', 'PanelController@newDocument');
Route::get('/utworz-dokument', 'PanelController@createDocument');
Route::get('/generuj-dokument', 'PanelController@generateDocument');
Route::get('/zwieksz-limit', 'PanelController@riseLimit');
Route::get('/zaplac', 'PanelController@pay');
Route::get('/ustawienia', 'PanelController@accountSettings');
Route::post('/usun-szablon', 'PanelController@postRemoveTemplate');
Route::post('/usun-dokument', 'PanelController@postRemoveDocument');
Route::post('/aktualizuj-szablon', 'PanelController@postUpdateTemplate');
Route::post('/zmien-haslo', 'PanelController@postChangePassword');

//Admin
Route::get('/ea-admin', 'AdminController@index');
Route::get('/ea-admin/blog', 'AdminController@blogList');
Route::get('/ea-admin/blog/wpis', 'AdminController@blog');
Route::get('/ea-admin/blog/wpis/{blog_id}', 'AdminController@blog');
Route::get('/ea-admin/blog/usun-wpis/{blog_id}', 'AdminController@deleteBlog');
Route::post('/ea-admin/blog/wpis', 'AdminController@postBlog');
Route::get('/ea-admin/statystyki', 'AdminController@stats');
Route::get('/ea-admin/uzytkownicy', 'AdminController@users');
Route::get('/ea-admin/poczta', 'AdminController@mails');
Route::post('/ea-admin/test-email', 'AdminController@postMails');
Route::get('/ea-admin/aktywuj-pakiet', 'AdminController@activatePackage');
Route::get('/ea-admin/aktywuj-pakiet/aktywuj/{declaration_id}', 'AdminController@doActivatePackage');
Route::get('/ea-admin/ustawienia-serwisu', 'AdminController@settings');

//REST responses
Route::post('/set-template', 'PanelController@restSetTemplate');
Route::post('/add-share', 'PanelController@restAddShare');
Route::post('/del-share', 'PanelController@restDelShare');
Route::post('/generate-document', 'PanelController@restGenerateDocument');
Route::post('/add-document', 'PanelController@restAddDocument');
Route::post('/set-document', 'PanelController@restSetDocument');
Route::get('/get-current-bitcoin', 'PanelController@restGetCurrentBitcoin');
Route::post('/get-current-price', 'PanelController@restGetCurrentPrice');
Route::post('/set-bitcoin-address', 'PanelController@restSetBitcoinAddress');
Route::post('/is-bitcoin-address', 'PanelController@restIsBitcoinAddress');
Route::post('/set-paypal-address', 'PanelController@restSetPayPalAddress');
Route::post('/is-paypal-address', 'PanelController@restIsPayPalAddress');
Route::post('/declare-payment', 'PanelController@restDeclarePayment');
Route::post('/usun-konto', 'PanelController@restDeleteUser');

//visualization
Route::get('/visualization/{filename}', function($filename){
  $file= public_path(). "\\visualization\\".$filename;
  $headers = array(
        'Content-Type: application/pdf',
      );
  return Response::download($file, $filename, $headers);
});

//Cron
Route::get('/PaU2HNhXL5PZxLc9Q3LqD9MB3QJgjKfykzYsNGQZc6qah3HxuUnytyzUPJByTgwD', 'CronController@main');
