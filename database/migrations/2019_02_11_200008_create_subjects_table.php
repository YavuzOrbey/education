<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('icon')->nullable();
            $table->timestamps();
        });

        DB::table('subjects')->insert([
            ['name'=>'SAT Critical Reading', 
            'icon' => 'fas fa-book',
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now()
            ],
            ['name' => 'SAT Writing and Language',
            'icon' => 'fas fa-highlighter',
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now()
            ],
            ['name' => 'SAT Math No Calculator',
            'icon' => 'fas fa-square-root-alt',
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now()
            ],
            ['name' => 'SAT Math Calculator',
            'icon' => 'fas fa-calculator',
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now()
            ]

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects');
    }
}
