<?php

use App\Http\Controllers\CSVExportController;
use Behat\Mink\Mink;
use Inertia\Inertia;
use Behat\Mink\Session;
use App\Models\ScrapingJob;
use Illuminate\Http\Request;
use App\Jobs\ProcessScrapingJob;
use DMore\ChromeDriver\ChromeDriver;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Symfony\Component\Process\Process;
use Imtigger\LaravelJobStatus\JobStatus;
use App\Http\Controllers\ScrapingJobsController;

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



Route::get("/", [ScrapingJobsController::class, "index"])->name("scrapingjobs.index");
Route::get("/jobs/{scrapingJob}", [ScrapingJobsController::class, "show"])->name("scrapingjob.detail");
Route::delete("/job/delete/{scrapingJob}", [ScrapingJobsController::class, "destroy"])->name("scrapingjob.delete");
Route::get("/csv/{id}", [CSVExportController::class, "exportCsv"])->name("export.csv");




Route::post("/scrape", function (Request $request) {
    //dd($request["keyword"]);
    $job = new ScrapingJob();
    $job->search_keyword = $request["keyword"];
    $query = str_replace(" ", "+", $job->search_keyword);
    $job->scraping_url = "https://www.google.com/search?q=$query&gl=us&hl=en&pws=0&sxsrf=AOaemvKoLVKo9jMPbb3yLSSLzau6ZeZmsg:1634143481724&source=hp&ei=-QxnYdDvKK-7gwfBmK_oBA&iflsig=ALs-wAMAAAAAYWcbCRUPzVpvB2Bkh3x84hck86MCteWO&uact=5&oq=jobs+near+me&gs_lcp=Cgdnd3Mtd2l6EAMyBwgjEMkDECcyBQgAEJIDMgUIABCRAjIFCAAQgAQyBQgAEIAEMgUIABCRAjIFCAAQgAQyBQgAEJECMgUIABCABDIFCAAQgAQ6BwgjEOoCECc6BAgjECc6CAgAEIAEELEDOgUIABCxAzoLCAAQgAQQsQMQgwE6BAguEEM6BAgAEEM6EAgAEIAEEIcCELEDEIMBEBQ6CggAELEDEIMBEEM6BwgAELEDEEM6BQgAEMsBOgoIABCABBCHAhAUUM4cWK4rYNEsaAFwAHgAgAHZAYgB-xCSAQUwLjguNJgBAKABAbABCg&sclient=gws-wiz&ibp=htl;jobs&sa=X&ved=2ahUKEwjEiIfx6sfzAhVPhv0HHZ-lAbsQutcGKAF6BAgSEAc#htivrt=jobs&fpstate=tldetail&htichips=date_posted:today&htischips=date_posted;today&htidocid=wV8eC2pg59uX1VBBAAAAAA%3D%3D";
    $job->save();
    ProcessScrapingJob::dispatch($job);

    return redirect()->route("scrapingjobs.index");
})->name("scrapingjob.create");



Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');