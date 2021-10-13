<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScrapingErrorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scraping_errors', function (Blueprint $table) {
            $table->id();
            $table->string("message");
            $table->foreignId("google_job_id")->references("id")->on("google_jobs");
            $table->foreignId("scraping_job_id")->references("id")->on("scraping_jobs");
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
        Schema::dropIfExists('scraping_errors');
    }
}
