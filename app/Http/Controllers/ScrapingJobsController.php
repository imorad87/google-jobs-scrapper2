<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\ScrapingJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

class ScrapingJobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Welcome', [
            'scrapingJobs' => ScrapingJob::orderBy('created_at', 'DESC')->get(),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ScrapingJob  $scrapingJob
     * @return \Illuminate\Http\Response
     */
    public function show(ScrapingJob $scrapingJob)
    {
        $id = $scrapingJob->id;
        $presistedJob = ScrapingJob::with(["googleJobs"])->find($id);
        return Inertia::render("ScrapingJobDetail", ["scrapingJob" => $presistedJob]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ScrapingJob  $scrapingJob
     * @return \Illuminate\Http\Response
     */
    public function edit(ScrapingJob $scrapingJob)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ScrapingJob  $googleJob
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ScrapingJob $scrapingJob)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ScrapingJob  $scrapingJob
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScrapingJob $scrapingJob)
    {
        //
    }
}