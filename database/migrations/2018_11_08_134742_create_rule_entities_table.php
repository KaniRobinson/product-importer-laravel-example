<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRuleEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rule_entities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rule_id')->unsigned()->index();
            $table->string('value');
            $table->integer('index');
            $table->timestamps();

            /**
             * Foreign Keys
             */
            $table->foreign('rule_id')
                  ->references('id')
                  ->on('rules')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rule_entities');
    }
}
