<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



return new class extends Migration {
    public function up()
    {
        Schema::dropIfExists('avatars'); // حذف الجدول إذا كان موجودًا
    }

    public function down()
    {
        Schema::create('avatars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained("users")->cascadeOnDelete();
            $table->string('avatar')->unique();
            $table->timestamps();
        });
    }
};

  