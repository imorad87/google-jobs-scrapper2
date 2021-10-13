<?php

namespace App\Jobs;

use App\Models\ScrapingJob;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

use Behat\Mink\Mink;
use Behat\Mink\Session;
use DMore\ChromeDriver\ChromeDriver;

class ProcessScrapingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $scrapingJob = null;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ScrapingJob $scrapingJob)
    {
        $this->scrapingJob = $scrapingJob->withoutRelations();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mink = new Mink(array(
            'browser' => new Session(new ChromeDriver('http://localhost:9222', null, 'http://www.google.com'))
        ));
    
        // set the default session name
        $mink->setDefaultSessionName('browser');
        $session = $mink->getSession();
        $session->start();
        $session->setRequestHeader("user-agent", "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.81 Safari/537.36");
    
        // visit a page
        $mink->getSession()->visit($this->scrapingJob->scraping_url);
    
        $page = $session->getPage();
        $session->executeScript("document.querySelector('.zxU94d.gws-plugins-horizon-jobs__tl-lvc').scrollTo(0, 5000)");
        sleep(5);
        $session->executeScript("document.querySelector('.zxU94d.gws-plugins-horizon-jobs__tl-lvc').scrollTo(0, 10000)");
        sleep(5);
        $session->executeScript("document.querySelector('.zxU94d.gws-plugins-horizon-jobs__tl-lvc').scrollTo(0, 15000)");
        sleep(5);
        $session->executeScript("document.querySelector('.zxU94d.gws-plugins-horizon-jobs__tl-lvc').scrollTo(0, 20000)");
        sleep(5);
        $session->executeScript("document.querySelector('.zxU94d.gws-plugins-horizon-jobs__tl-lvc').scrollTo(0, 25000)");
        sleep(5);
        // $session->executeScript("document.querySelector('.zxU94d.gws-plugins-horizon-jobs__tl-lvc').scrollTo(0, 30000)");
        // sleep(5);
        // $session->executeScript("document.querySelector('.zxU94d.gws-plugins-horizon-jobs__tl-lvc').scrollTo(0, 35000)");
        // sleep(5);
        // $session->executeScript("document.querySelector('.zxU94d.gws-plugins-horizon-jobs__tl-lvc').scrollTo(0, 40000)");
    
        $jobsContainers = $page->findAll("css", "#VoQFxe > div ul");
    
        foreach ($jobsContainers as $jobContainer) {
            $jobItems = $jobContainer->findAll("css", "li");
            foreach ($jobItems as $job) {
                $job->click();
                sleep(5);
                try {
                    $session->executeScript("document.querySelector('#gws-plugins-horizon-jobs__job_details_page > div > div.YgLbBe > div').classList.toggle('config-text-expandable';)");
                } catch (\Throwable $th) {
                    echo $th->getMessage() . PHP_EOL;
                }
                echo ($page->find("css", "#gws-plugins-horizon-jobs__job_details_page > div > div.sVx81 > div > div.sH3zFd > h2")->getText());
                sleep(10);
                
            }
        }
    
        
    }
}
