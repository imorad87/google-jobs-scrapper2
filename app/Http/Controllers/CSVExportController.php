<?php

namespace App\Http\Controllers;

use App\Exports\GoogleJobsExport;
use Carbon\Carbon;
use App\Models\GoogleJob;
use App\Models\ScrapingJob;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;

class CSVExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function exportCsv(Request $request, $id)
    {
        $now = Carbon::now();
        $fileName = "googleJobsExport-$now.csv";
        $scrapingJob = ScrapingJob::with(["googleJobs"])->find($id);
        $googleJobs = $scrapingJob->googleJobs;
        $file = null;
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Id', 'JobTitle', 'JobType', 'JobDescription', 'CompanyName', 'Salary', 'Location', 'PostedSince', 'ContactName', 'ContactEmail', 'CreatedAt', 'UpdatedAt', 'ScrapingJobId');

        $callback = function () use ($googleJobs, $columns, $id) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, "~");

            foreach ($googleJobs as $googleJob) {
                $row['Id']  =  $googleJob->id;
                $row['JobTitle']    =  $googleJob->job_title;
                $row['JobType']    =  $googleJob->job_type;
                $row['JobDescription']    =  $googleJob->job_description;
                $row['CompanyName']  =  $googleJob->company_name;
                $row['Salary']  =   $googleJob->salary;
                $row['Location']  =  $googleJob->location;
                $row['PostedSince']  =   $googleJob->posted_since;
                $row['ContactName']  =  $googleJob->contact_name;
                $row['ContactEmail']  =  $googleJob->contact_email;
                $row['CreatedAt']  =   $googleJob->created_at;
                $row['UpdatedAt']  =   $googleJob->updated_at;
                $row['ScrapingJobId']  =   $id;

                fputcsv($file, array(
                    $row['Id'],
                    $row['JobTitle'],
                    $row['JobType'],
                    $row['JobDescription'],
                    $row['CompanyName'],
                    $row['Salary'],
                    $row['Location'],
                    $row['PostedSince'],
                    $row['ContactName'],
                    $row['ContactEmail'],
                    $row['CreatedAt'],
                    $row['UpdatedAt'],
                    $row['ScrapingJobId']
                ), "~");
            }

            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}