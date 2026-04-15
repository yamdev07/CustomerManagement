<?php

namespace App\Contracts;

interface MessagingServiceInterface
{
    /**
     * Envoyer un SMS.
     *
     * @return array{success: bool, error?: string, sid?: string, message?: string}
     */
    public function sendSMS(string $to, string $message): array;

    /**
     * Envoyer un message WhatsApp.
     *
     * @return array{success: bool, error?: string, sid?: string, message?: string}
     */
    public function sendWhatsApp(string $to, string $message): array;

    /**
     * Envoyer un template WhatsApp avec des placeholders.
     */
    public function sendWhatsAppTemplate(string $to, string $templateName, array $placeholders = []): bool;

    /**
     * Vérifier le statut d'un message envoyé.
     *
     * @return array{success: bool, status?: string, error?: string}
     */
    public function getMessageStatus(string $messageSid): array;
}
