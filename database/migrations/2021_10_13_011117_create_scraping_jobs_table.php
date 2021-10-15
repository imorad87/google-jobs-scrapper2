<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScrapingJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scraping_jobs', function (Blueprint $table) {
            $table->id();
            $table->string("search_keyword");
            $table->longText("scraping_url");
            $table->boolean("finished")->nullable();
            $table->boolean("successfull")->nullable();
            $table->timestamp("finished_at")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scraping_jobs');
    }
}