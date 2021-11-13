<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->id();
            $table
                ->string('name', 63)
                ->collation('utf8mb4_unicode_ci')
                ->comment('English country name.');
            $table
                ->char('iso2', 2)
                ->collation('ascii_bin')
                ->comment('ISO 3166-2 two letter upper case country code.');
            $table
                ->char('iso3', 3)
                ->collation('ascii_bin')
                ->comment('ISO 3166-3 three letter upper case country code.');
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
        Schema::dropIfExists('countries');
    }
}
