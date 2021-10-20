<?php

namespace App\Exports;

use App\Models\ScrapingJob;
use Maatwebsite\Excel\Concerns\FromCollection;

class GoogleJobsExport implements FromCollection
{

    protected $id;
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return ScrapingJob::with("googleJobs")->find($this->id)->googleJobs;
    }
}