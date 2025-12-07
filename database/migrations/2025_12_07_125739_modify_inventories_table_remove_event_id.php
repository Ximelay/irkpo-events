<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            // Удаляем внешний ключ
            $table->dropForeign('fk_Inventories_events1');
            // Удаляем колонку events_eventID
            $table->dropColumn('events_eventID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            // Восстанавливаем колонку
            $table->integer('events_eventID')->after('inventoryCategories_inventoryCategoryID');
            // Восстанавливаем внешний ключ
            $table->foreign('events_eventID', 'fk_Inventories_events1')
                ->references('eventID')
                ->on('events')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
};
