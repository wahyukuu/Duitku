<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Libraries\WhatsAppService;

class WhatsApp extends ResourceController
{
    /**
     * Simple test endpoint to send a template message.
     * URL: /whatsapp/test?to=+6281234567890
     */
    public function test()
    {
        $to = $this->request->getGet('to');
        if (empty($to)) {
            return $this->fail('Parameter "to" is required (e.g. +628123456789)', 400);
        }

        $whats = new WhatsAppService();
        // Example template – you must create this template in Meta Business Manager first.
        $template = 'transaction_alert';
        $components = [
            [
                'type' => 'body',
                'parameters' => [
                    ['type' => 'text', 'text' => 'Pembayaran berhasil'],
                    ['type' => 'currency', 'currency' => ['code' => 'IDR', 'amount' => 1500000]],
                ],
            ],
        ];

        $sent = $whats->sendTemplate($to, $template, $components);
        if ($sent) {
            return $this->respond(['status' => 'sent']);
        }
        return $this->fail('Failed to send WhatsApp message', 500);
    }
}
?>
