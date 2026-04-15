<?php

namespace App\Actions\Client;

use App\Models\Client;
use Carbon\Carbon;

class SyncClientStatusAction
{
    /**
     * Synchroniser le statut de tous les clients selon leurs paiements et dates de réabonnement.
     */
    public function execute(): void
    {
        $today       = Carbon::today();
        $moisCourant = $today->month;
        $anneeCourante = $today->year;

        Client::chunk(100, function ($clients) use ($today, $moisCourant, $anneeCourante) {
            foreach ($clients as $client) {
                $this->syncSingleClient($client, $today, $moisCourant, $anneeCourante);
            }
        });
    }

    /**
     * Synchroniser un seul client.
     */
    private function syncSingleClient(Client $client, Carbon $today, int $moisCourant, int $anneeCourante): void
    {
        // Vérifier si le client a payé ce mois
        $client->a_paye = $client->estPayePourMois($moisCourant, $anneeCourante);

        // Suspension automatique si la date limite est dépassée
        // On ne change pas le statut si le client a été suspendu manuellement
        if ($client->date_reabonnement && $client->statut !== Client::STATUS_SUSPENDU) {
            $dateLimite = $client->date_reabonnement->copy()->addMonths(2);

            if ($today->gt($dateLimite)) {
                $client->statut = Client::STATUS_SUSPENDU;
            }
        }

        // Calculer le prochain mois dû
        $client->prochain_mois_du = $client->prochainMoisDu()->format('Y-m-d');

        $client->saveQuietly();
    }
}
