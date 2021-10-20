<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoogleJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('google_jobs', function (Blueprint $table) {
            $table->id();
            $table->string("job_title");
            $table->string("job_type");
            $table->longText("job_description")->nullable();
            $table->string("salary")->nullable();
            $table->string("location")->nullable();
            $table->string("company_name");
            $table->string("company_website")->nullable();
            $table->string("company_logo")->nullable();
            $table->string("posted_since");
            $table->string("contact_name")->nullable();
            $table->string("contact_email")->nullable();
            $table->timestamps();
            $table->foreignId("scraping_job_id")->references("id")->on("scraping_jobs")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('google_jobs');
    }
}