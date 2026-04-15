<?php

namespace App\Actions\Client;

use App\Models\Client;
use App\Models\Paiement;
use Carbon\Carbon;

class ProcessClientPaymentAction
{
    /**
     * Traiter le paiement d'un client et mettre à jour son réabonnement.
     */
    public function execute(Client $client, ?Carbon $paymentDate = null): void
    {
        $paymentDate = $paymentDate ?? Carbon::today();

        // 1. Récupérer le mois impayé le plus ancien ou créer le paiement courant
        $moisImpaye = $client->paiements()
            ->where('statut', false)
            ->orderBy('annee')
            ->orderBy('mois')
            ->first();

        if ($moisImpaye) {
            $moisImpaye->update([
                'statut'        => true,
                'date_paiement' => $paymentDate,
            ]);

            $mois  = $moisImpaye->mois;
            $annee = $moisImpaye->annee;
        } else {
            $mois  = $paymentDate->month;
            $annee = $paymentDate->year;

            Paiement::create([
                'client_id'     => $client->id,
                'mois'          => $mois,
                'annee'         => $annee,
                'statut'        => true,
                'montant'       => $client->montant,
                'date_paiement' => $paymentDate,
            ]);
        }

        // 2. Mise à jour de la date de réabonnement
        $this->updateReabonnementDate($client, $annee, $mois);

        // 3. Statut actif et payé
        $client->update([
            'statut' => Client::STATUS_ACTIF,
            'a_paye' => true,
        ]);
    }

    /**
     * Mettre à jour la date de réabonnement selon le jour configuré.
     */
    private function updateReabonnementDate(Client $client, int $annee, int $mois): void
    {
        if (!$client->jour_reabonnement) {
            return;
        }

        $jour = min($client->jour_reabonnement, Carbon::create($annee, $mois, 1)->endOfMonth()->day);
        $client->date_reabonnement = Carbon::create($annee, $mois, $jour);
    }
}
