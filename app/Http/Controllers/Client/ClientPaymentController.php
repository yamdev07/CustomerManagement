<?php

namespace App\Http\Controllers\Client;

use App\Actions\Client\ProcessClientPaymentAction;
use App\Http\Controllers\Controller;
use App\Models\Client;

class ClientPaymentController extends Controller
{
    /**
     * Marquer un client comme payé.
     */
    public function markAsPaid(Client $client, ProcessClientPaymentAction $processPayment)
    {
        $processPayment->execute($client);

        return redirect()->back()
            ->with('success', 'Client marqué comme payé et date de réabonnement mise à jour.');
    }

    /**
     * Reconnecter un client (paiement + réabonnement).
     */
    public function reconnect(Client $client, ProcessClientPaymentAction $processPayment)
    {
        $processPayment->execute($client);

        return redirect()->back()
            ->with('success', 'Client reconnecté et date de réabonnement mise à jour.');
    }

    /**
     * Déconnecter un client (marquer non payé).
     */
    public function disconnect(Client $client)
    {
        $client->update(['a_paye' => false]);

        return redirect()->back()
            ->with('success', 'Client déconnecté avec succès (non payé).');
    }
}
