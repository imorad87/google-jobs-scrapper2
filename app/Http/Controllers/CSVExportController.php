<?php

namespace App\Http\Controllers;

use App\Exports\GoogleJobsExport;
use App\Models\ApplyLink;
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
        try {
            $now = Carbon::now();
            $fileName = "googleJobsExport-$now.csv";
            $scrapingJob = ScrapingJob::with(["googleJobs"])->find($id);
            $googleJobs = $scrapingJob->googleJobs;

            // $jobWithLinks = $googleJobs[0]->load("applyLinks");
            // $applyLinks = $jobWithLinks->applyLinks;

            // $links = "";

            // foreach ($applyLinks as $applyLink) {
            //     //ddd([$applyLink->link, $applyLink->note]);
            //     $links = $links . "~" . $applyLink->link . ":" .  $applyLink->note;
            // }
            // ddd($links);
            $file = null;
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );

            $columns = array('Id', 'JobTitle', 'JobType', 'JobDescription', 'CompanyName', 'Salary', 'Location', 'PostedSince', 'ContactName', 'ContactEmail', 'CreatedAt', 'UpdatedAt', 'ScrapingJobId', 'ApplyLinks');

            $callback = function () use ($googleJobs, $columns, $id) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns, "~");



                foreach ($googleJobs as $googleJob) {
                    $jobWithLinks = $googleJob->load("applyLinks");

                    $row['Id']                  =  $jobWithLinks->id;
                    $row['JobTitle']            =  $jobWithLinks->job_title;
                    $row['JobType']             =  $jobWithLinks->job_type;
                    $row['JobDescription']      =  $jobWithLinks->job_description;
                    $row['CompanyName']         =  $jobWithLinks->company_name;
                    $row['Salary']              =  $jobWithLinks->salary;
                    $row['Location']            =  $jobWithLinks->location;
                    $row['PostedSince']         =  $jobWithLinks->posted_since;
                    $row['ContactName']         =  $jobWithLinks->contact_name;
                    $row['ContactEmail']        =  $jobWithLinks->contact_email;
                    $row['CreatedAt']           =  $jobWithLinks->created_at;
                    $row['UpdatedAt']           =  $jobWithLinks->updated_at;
                    $row['ScrapingJobId']       =  $id;

                    $applyLinks = $jobWithLinks->applyLinks;

                    $links = "";
                    $a = 0;
                    foreach ($applyLinks as $applyLink) {
                        $a++;
                        if ($a > 1) {
                            $links = $links . $applyLink->link . ": " .  $applyLink->note . "\n";
                        } else {
                            $links = $links . $applyLink->link . ": " .  $applyLink->note;
                        }
                    }

                    $row["ApplyLinks"] = $links;

                    //dd($links);

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
                        $row['ScrapingJobId'],
                        $row["ApplyLinks"]
                    ), "~");
                }

                fclose($file);
            };
            return response()->stream($callback, 200, $headers);
        } catch (\Throwable $th) {
            ddd($th);
        }
    }
}