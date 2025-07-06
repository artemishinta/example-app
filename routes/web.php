<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\HelloWorldController;
// use App\Http\Controllers\HtmlController;
// use App\Http\Controllers\LatihanController;

// use App\Http\Controllers\AnggotaController;

// use App\Http\Controllers\BerandaController;
// use App\Http\Controllers\LoginController;

// use App\Http\Controllers\UserController;
// use App\Http\Controllers\KategoriController;
// use App\Http\Controllers\ProdukController;




// Route::get('/', function () {
//     // return view('welcome');
//     return redirect()->route('backend.login');

//     });



// Route::get('/helloworld', [HelloWorldController::class, 'index']);
// Route::get('ambilfile',[HelloWorldController::class, 'ambilFile']);
// Route::get('getlorem',[HtmlController::class, 'getlorem']);
// Route::get('getTabel',[LatihanController::class, 'getTabel']);
// Route::get('getForm',[LatihanController::class, 'getForm']);




// Route::get('backend/beranda', [BerandaController::class, 'berandaBackend'])->name('backend.beranda');
// Route::get('backend/beranda', [BerandaController::class, 'berandaBackend'])->name('backend.beranda')->middleware('auth');
// Route::get('backend/login', [LoginController::class, 'loginBackend'])->name('backend.login');
// Route::post('backend/login', [LoginController::class, 'authenticateBackend'])->name('backend.login');
// Route::post('backend/logout', [LoginController::class, 'logoutBackend'])->name('backend.logout');

// Route::resource('backend/user', UserController::class, ['as' => 'backend'])->middleware('auth');
// Route::resource('user', UserController::class);
// Route::resource('user', UserController::class, ['as' => 'backend']);
// Route::resource('backend/kategori', KategoriController::class, ['as' => 'backend'])->middleware('auth');

// Route::resource('backend/produk', ProdukController::class, ['as' => 'backend'])->middleware('auth');

// Route untuk menambahkan foto
// Route::post('foto-produk/store', [ProdukController::class, 'storeFoto'])->name('backend.foto_produk.store')->middleware('auth');
// Route untuk menghapus foto
// Route::delete('foto-produk/{id}', [ProdukController::class, 'destroyFoto'])->name('backend.foto_produk.destroy')->middleware('auth');



// Route::get('backend/laporan/formuser', [UserController::class, 'formUser'])->name('backend.laporan.formuser')->middleware('auth');
// Route::post('backend/laporan/cetakuser', [UserController::class, 'cetakUser'])->name('backend.laporan.cetakuser')->middleware('auth');

// Route::get('backend/laporan/formproduk', [ProdukController::class, 'formProduk'])->name('backend.laporan.formproduk')->middleware('auth');
// Route::post('backend/laporan/cetakproduk', [ProdukController::class, 'cetakProduk'])->name('backend.laporan.cetakproduk')->middleware('auth');

use App\Http\Controllers\AnggotaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\RajaOngkirController;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('beranda');
});


Route::get('/anggota/index', [AnggotaController::class, 'index'])->name('anggota.index');

Route::get('backend/beranda', [BerandaController::class, 'berandaBackend'])
->name('backend.beranda')->middleware('auth');

Route::get('backend/login', [LoginController::class, 'loginBackend'])
->name('backend.login');
Route::post('backend/login', [LoginController::class, 'authenticateBackend'])
->name('backend.login');
Route::post('backend/logout', [LoginController::class, 'logoutBackend'])
->name('backend.logout');

// Route untuk User
// Route::resource('backend/user', UserController::class)->middleware('auth');
Route::resource('backend/user', UserController::class, ['as' => 'backend'])
->middleware('auth');
// Route untuk laporan user
Route::get('backend/laporan/formuser', [UserController::class, 'formUser'])
->name('backend.laporan.formuser')->middleware('auth');
Route::post('backend/laporan/cetakuser', [UserController::class, 'cetakUser'])
->name('backend.laporan.cetakuser')->middleware('auth');

// Route untuk Kategori
Route::resource('backend/kategori', KategoriController::class, ['as' => 'backend'])
->middleware('auth');

// Route untuk Produk
Route::resource('backend/produk', ProdukController::class, ['as' => 'backend'])
->middleware('auth');
// Route untuk menambahkan foto
Route::post('foto-produk/store', [ProdukController::class, 'storeFoto'])
->name('backend.foto_produk.store')->middleware('auth');
// Route untuk menghapus foto
Route::delete('foto-produk/{id}', [ProdukController::class, 'destroyFoto'])
->name('backend.foto_produk.destroy')->middleware('auth');
// Route untuk laporan produk
Route::get('backend/laporan/formproduk', [ProdukController::class, 'formProduk'])
->name('backend.laporan.formproduk')->middleware('auth');
Route::post('backend/laporan/cetakproduk', [ProdukController::class, 'cetakProduk'])
->name('backend.laporan.cetakproduk')->middleware('auth');

// Frontend
Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');

route::get('/produk/detail/{id}', [ProdukController::class, 'detail'])->name('produk.detail');

route::get('/produk/kategori/{id}', [ProdukController::class,
'produkKategori'])->name('produk.kategori');

route::get('/produk/all', [ProdukController::class, 'produkAll'])->name('produk.all');

// API Google
Route::get('/auth/redirect', [CustomerController::class, 'redirect'])->name('auth.redirect');
Route::get('/auth/google/callback', [CustomerController::class, 'callback'])->name('auth.callback');

// Logout
Route::match(['get', 'post'], '/logout', [CustomerController::class, 'logout'])->name('customer.logout');

// Route untuk Customer
Route::resource('backend/customer', CustomerController::class, ['as' => 'backend'])
->middleware('auth');

// Group route untuk customer
Route::middleware('is.customer')->group(function () {
    // Route untuk menampilkan halaman akun customer
    Route::get('/customer/akun/{id}', [CustomerController::class, 'akun']) ->name('customer.akun');

    // Route untuk mengupdate data akun customer
    Route::put('/customer/updateakun/{id}', [CustomerController::class, 'updateAkun']) ->name('customer.updateakun');

     // Route untuk menambahkan produk ke keranjang
    Route::post('add-to-cart/{id}', [OrderController::class, 'addToCart'])->name('order.addToCart');
    Route::get('cart', [OrderController::class, 'viewCart'])->name('order.cart');
    Route::post('cart/update/{id}', [OrderController::class, 'updateCart'])->name('order.updateCart');
    Route::post('remove/{id}', [OrderController::class, 'removeFromCart'])->name('order.remove');
    Route::post('select-shipping', [OrderController::class, 'selectShipping'])->name('order.select-shipping');
    Route::post('update-ongkir', [OrderController::class, 'updateOngkir'])->name('order.update-ongkir');
    //midtrans
    Route::get('select-payment', [OrderController::class, 'selectPayment'])->name('order.selectpayment');
    Route::post('/midtrans-callback', [OrderController::class, 'callback']);
    Route::get('/order/complete', [OrderController::class, 'complete'])->name('order.complete');
    // Route history
    Route::get('history', [OrderController::class, 'orderHistory'])->name('order.history');
    Route::get('order/invoice/{id}', [OrderController::class, 'invoiceFrontend'])->name('order.invoice');
});

    // Ongkir
    Route::get('select-shipping', [OrderController::class, 'selectShipping'])->name('order.selectShipping');
    Route::get('provinces', [OrderController::class, 'getProvinces']);
    Route::get('cities', [OrderController::class, 'getCities']);
    Route::post('costs', [OrderController::class, 'getCosts']);
    Route::post('updateongkir', [OrderController::class, 'updateOngkir'])->name('order.updateOngkir');

    Route::get('/list-ongkir', function () {
        $response = Http::withHeaders([
        'key' => 'your_api_key'
        ])->get('https://api.rajaongkir.com/starter/province'); //ganti 'province' atau 'city'
        dd($response->json());
    });

    Route::get('/cek-ongkir', function () {
        return view('ongkir');});

    Route::get('/provinces', [RajaOngkirController::class, 'getProvinces']);
    Route::get('/cities', [RajaOngkirController::class, 'getCities']);
    Route::post('/cost', [RajaOngkirController::class, 'getCost']);
