<?php

use App\Jobs\ProcessScrapingJob;
use App\Models\ScrapingJob;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Behat\Mink\Mink;
use Behat\Mink\Session;
use DMore\ChromeDriver\ChromeDriver;
use Symfony\Component\Process\Process;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::get("/d", function () {
    $job = new ScrapingJob();
    $job->search_keyword = "food scientist";
    $query = str_replace(" ", "+", $job->search_keyword);
    $job->scraping_url = "https://www.google.com/search?q=$query&gl=us&hl=en&pws=0&sxsrf=AOaemvKoLVKo9jMPbb3yLSSLzau6ZeZmsg:1634143481724&source=hp&ei=-QxnYdDvKK-7gwfBmK_oBA&iflsig=ALs-wAMAAAAAYWcbCRUPzVpvB2Bkh3x84hck86MCteWO&uact=5&oq=jobs+near+me&gs_lcp=Cgdnd3Mtd2l6EAMyBwgjEMkDECcyBQgAEJIDMgUIABCRAjIFCAAQgAQyBQgAEIAEMgUIABCRAjIFCAAQgAQyBQgAEJECMgUIABCABDIFCAAQgAQ6BwgjEOoCECc6BAgjECc6CAgAEIAEELEDOgUIABCxAzoLCAAQgAQQsQMQgwE6BAguEEM6BAgAEEM6EAgAEIAEEIcCELEDEIMBEBQ6CggAELEDEIMBEEM6BwgAELEDEEM6BQgAEMsBOgoIABCABBCHAhAUUM4cWK4rYNEsaAFwAHgAgAHZAYgB-xCSAQUwLjguNJgBAKABAbABCg&sclient=gws-wiz&ibp=htl;jobs&sa=X&ved=2ahUKEwjEiIfx6sfzAhVPhv0HHZ-lAbsQutcGKAF6BAgSEAc#htivrt=jobs&fpstate=tldetail&htichips=date_posted:today&htischips=date_posted;today&htidocid=wV8eC2pg59uX1VBBAAAAAA%3D%3D";
    $job->save();
    ProcessScrapingJob::dispatch($job);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
