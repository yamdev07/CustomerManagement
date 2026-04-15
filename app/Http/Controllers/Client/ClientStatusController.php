<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;

class ClientStatusController extends Controller
{
    /**
     * Suspendre un client.
     */
    public function suspend(Client $client)
    {
        $client->update(['statut' => Client::STATUS_SUSPENDU]);

        return redirect()->back()
            ->with('success', 'Client suspendu avec succès.');
    }

    /**
     * Réactiver un client.
     */
    public function reactivate(Client $client)
    {
        $client->update(['statut' => Client::STATUS_ACTIF]);

        return redirect()->back()
            ->with('success', 'Client réactivé avec succès.');
    }
}
