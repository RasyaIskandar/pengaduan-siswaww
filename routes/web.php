<?php


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\ProfileController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Group untuk profile yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Route khusus untuk role "siswa"
Route::group(['middleware' => ['auth', 'role:siswa']], function () {
    Route::get('/siswa/index', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
    Route::post('/siswa/store', [SiswaController::class, 'store'])->name('siswa.store');


    // Tambahkan route lain khusus siswa di sini
});


// Route khusus untuk role "guru"
Route::group(['middleware' => ['auth', 'role:guru']], function () {
    Route::get('/guru/index', [GuruController::class, 'index'])->name('guru.index');
    // Tambahkan route lain khusus guru di sini
});

route::patch('/siswa/{id}/complete', [SiswaController::class, 'selesai'])->name('siswa.complete');

Route::resource('siswa', SiswaController::class);

// Auth routes
require __DIR__.'/auth.php';

Route::get('/news', function () {
    $apiKey = env('NEWS_API_KEY');
    $response = Http::get("https://newsapi.org/v2/top-headlines?country=us&apiKey={$apiKey}");
    $news = $response->json();
    return view('welcome', ['news' => $news['articles']]);
});

route::resource('news', NewsController::class);






