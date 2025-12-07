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
        Schema::create('eventInventory', function (Blueprint $table) {
            $table->integer('eventInventoryID')->autoIncrement()->comment('Уникальный идентификатор связи');
            $table->integer('events_eventID')->comment('ID мероприятия');
            $table->integer('inventories_inventoryID')->comment('ID инвентаря');
            $table->integer('quantity')->default(1)->comment('Количество единиц инвентаря для мероприятия');
            $table->timestamp('addedAt')->useCurrent()->comment('Дата добавления инвентаря к мероприятию');

            $table->primary('eventInventoryID');

            // Уникальное ограничение - один инвентарь можно добавить к мероприятию только один раз
            $table->unique(['events_eventID', 'inventories_inventoryID'], 'unique_event_inventory');

            // Внешние ключи
            $table->foreign('events_eventID', 'fk_eventInventory_events')
                ->references('eventID')
                ->on('events')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('inventories_inventoryID', 'fk_eventInventory_inventories')
                ->references('inventoryID')
                ->on('inventories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventInventory');
    }
};
