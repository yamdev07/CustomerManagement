<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Migration consolidée pour la table clients.
     * Remplace les migrations fragmentées précédentes.
     */
    public function up(): void
    {
        // Si la table existe déjà (dev), on la recrée proprement
        if (Schema::hasTable('clients')) {
            Schema::dropIfExists('clients');
        }

        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('nom_client');
            $table->string('contact');
            $table->string('email')->nullable();
            $table->string('sites_relais')->nullable();
            $table->string('lieu')->nullable();
            $table->string('categorie')->nullable();
            $table->string('statut')->default('inactif'); // actif, inactif, suspendu
            $table->integer('jour_reabonnement')->nullable(); // jour du mois pour le réabonnement (1-31)
            $table->date('date_reabonnement')->nullable();
            $table->decimal('montant', 10, 2)->nullable();
            $table->boolean('a_paye')->default(false);
            $table->timestamps();

            $table->index('statut');
            $table->index('date_reabonnement');
            $table->index('a_paye');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
