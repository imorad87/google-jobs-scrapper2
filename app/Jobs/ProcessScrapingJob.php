<?php

namespace App\Jobs;

use DateTime;
use Behat\Mink\Mink;
use Behat\Mink\Session;
use App\Models\GoogleJob;
use App\Models\ScrapingJob;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use DMore\ChromeDriver\ChromeDriver;
use Illuminate\Queue\SerializesModels;

use Illuminate\Queue\InteractsWithQueue;
use Imtigger\LaravelJobStatus\Trackable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessScrapingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Trackable;

    protected $scrapingJob = null;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ScrapingJob $scrapingJob)
    {
        $this->prepareStatus();
        $this->scrapingJob = $scrapingJob;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $agents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.157 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36',
            'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36',
            'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36',
            'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36',
            'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.83 Safari/537.1',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36',
            'Mozilla/5.0 (Windows NT 5.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36',
            'Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36',
            'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.102 Safari/537.36',
            'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36',
        ];
        $mink = new Mink(array('browser' => new Session(new ChromeDriver('http://localhost:9222', null, 'http://www.google.com'))));

        // set the default session name
        $mink->setDefaultSessionName('browser');
        $session = $mink->getSession();
        $session->start();
        $session->setRequestHeader("user-agent", collect($agents)->random());

        // visit a page
        $mink->getSession()->visit($this->scrapingJob->scraping_url);

        $session->executeScript("document.querySelector('.zxU94d.gws-plugins-horizon-jobs__tl-lvc').scrollTo(0, 5000);");
        sleep(5);
        $session->executeScript("document.querySelector('.zxU94d.gws-plugins-horizon-jobs__tl-lvc').scrollTo(0, 10000);");
        sleep(5);
        $session->executeScript("document.querySelector('.zxU94d.gws-plugins-horizon-jobs__tl-lvc').scrollTo(0, 15000);");
        sleep(5);
        $session->executeScript("document.querySelector('.zxU94d.gws-plugins-horizon-jobs__tl-lvc').scrollTo(0, 20000);");
        sleep(5);
        $session->executeScript("document.querySelector('.zxU94d.gws-plugins-horizon-jobs__tl-lvc').scrollTo(0, 25000);");
        sleep(5);
        $session->executeScript("document.querySelector('.zxU94d.gws-plugins-horizon-jobs__tl-lvc').scrollTo(0, 30000);");
        sleep(5);
        $session->executeScript("document.querySelector('.zxU94d.gws-plugins-horizon-jobs__tl-lvc').scrollTo(0, 35000);");
        sleep(5);
        $session->executeScript("document.querySelector('.zxU94d.gws-plugins-horizon-jobs__tl-lvc').scrollTo(0, 40000);");


        try {
            $jobContainer = $session->getPage()->findAll("css", "div.pE8vnd.avtvi");
            echo (count($jobContainer));
            foreach ($jobContainer as $container) {
                $jobTitle = $container->find("css", "div.sH3zFd > h2")->getText();
                $companyName = $container->find("css", "div.nJlQNd.sMzDkb")->getText();
                $location = $container->find("css", "div.tJ9zfc > div:nth-child(2)")->getText();
                $jobTypeElement = $container->find("css", "div.ocResc.icFQAc > span:nth-child(2) > span.SuWscb");

                if (!$jobTypeElement) {
                    $jobTypeElement = $container->find("css", "div.ocResc > div:nth-child(3) > span.SuWscb");
                }

                $jobType = $jobTypeElement->getText();

                $postedSince = $container->find("css", "div.ocResc.icFQAc > span:nth-child(1) > span.SuWscb")->getText();
                try {
                    $jobDescription = $container->find("css", "div.YgLbBe.YRi0le > div > span")->getText();
                } catch (\Throwable $th) {
                    $jobDescription = "NA";
                }
                try {
                    $logo = $container->find("css", "div.ZUeoqc > span > g-img img")->getAttribute("src");
                } catch (\Throwable $th) {
                    $logo = "NA";
                }
                $links = $container->findAll("css", "a[jsaction='trigger.GoJgKc']");
                $hrefs = [];
                foreach ($links as $link) {
                    $hrefs[str_replace(" ", "_", $link->getText())] = $link->getAttribute("href");
                }

                echo ($jobTitle . "|" . $companyName . "|" . $location . "|" . $jobType . "|" . $postedSince . "|" . $jobDescription . "|" . $logo . "|" . var_dump($hrefs) . PHP_EOL . PHP_EOL);
                try {
                    $createdJob = $this->scrapingJob->googleJobs()->create([
                        "job_title" => $jobTitle,
                        "job_type" => $jobType,
                        "job_description" => $jobDescription,
                        "salary" => "",
                        "location" => $location,
                        "company_name" => $companyName,
                        "company_website" => "",
                        "company_logo" => $logo,
                        "posted_since" => $postedSince,
                        "contact_name" => "",
                        "contact_email" => "",
                    ]);

                    foreach ($hrefs as $key => $value) {

                        $createdJob->applyLinks()->create([
                            "note" => $value,
                            "link" => $key
                        ]);
                    }

                    $this->scrapingJob->finished = true;
                    $this->scrapingJob->successfull = true;
                    $now = Carbon::now();
                    $this->scrapingJob->finished_at = $now->toDateTimeString();
                    $this->scrapingJob->save();
                } catch (\Throwable $th) {
                    echo ($th);
                }
            }
        } catch (\Throwable $th) {
            echo ($th);
        }
    }


    private function scrapeJob($page)
    {
        //echo ("started scraping a job" . PHP_EOL);
        $jobTitle = $page->findAll("css", "#gws-plugins-horizon-jobs__job_details_page > div > div.sVx81 > div > div.sH3zFd > h2");
        $companyName = $page->findAll("css", "div.nJlQNd.sMzDkb");
        $location = $page->findAll("css", "div.tJ9zfc > div:nth-child(2)");
        $jobType = $page->findAll("css", "div.ocResc.icFQAc > span:nth-child(2) > span.SuWscb");
        $postedSince = $page->findAll("css", "#gws-plugins-horizon-jobs__job_details_page > div > div.ocResc.icFQAc > span:nth-child(1) > span.SuWscb");
        $jobDescription = $page->findAll("css", "#gws-plugins-horizon-jobs__job_details_page > div > div.YgLbBe.YRi0le > div > span");
        $logo = $page->findAll("css", "div.ZUeoqc > span > g-img > img");
        $links = count($page->findAll("css", ".pMhGee.Co68jc.j0vryd"));


        echo (count($jobTitle) . "|" . count($companyName) . "|" . count($location) . "|" . count($jobType) . "|" . count($postedSince) . "|" . count($jobDescription) . "|" . count($logo) . "|" . $links);
        exit();
        echo ($jobTitle . "|||" .
            $companyName . "|||" .
            $location . "|||" .
            $jobType . "|||" .
            $postedSince . "|||" .
            substr($jobDescription, 0, 100) . "|||" .
            $links . "|||" .
            $logo . PHP_EOL . PHP_EOL);

        try {
            $this->scrapingJob->googleJobs()->create([
                "job_title" => $jobTitle,
                "job_type" => $jobType,
                "job_description" => $jobDescription,
                "salary" => "",
                "location" => $location,
                "company_name" => "",
                "company_website" => "",
                "company_logo" => $logo,
                "posted_since" => $postedSince,
                "contact_name" => "",
                "contact_email" => "",
            ]);
            $this->scrapingJob->save();
        } catch (\Throwable $th) {
            echo ($th);
        }
    }
}