<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriveTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drive_tag', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Drive::class)
                ->constrained('drives');
            $table->foreignIdFor(\App\Models\Tag::class)
                ->constrained('tags');
        });
    }
}
