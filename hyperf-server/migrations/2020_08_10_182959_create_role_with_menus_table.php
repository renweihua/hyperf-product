<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateRoleWithMenusTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('role_with_menus')) return;
        Schema::create('role_with_menus', function (Blueprint $table) {
            $table->bigIncrements('with_id');
            $table->integer('role_id')->unsigned()->default(0)->comment('角色Id');
            $table->integer('menu_id')->unsigned()->default(0)->comment('菜单Id');
            $table->index('role_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_menus');
    }
}
