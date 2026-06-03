<?php
namespace App\Libraries;

/**
 * Simple wrapper for WhatsApp Cloud API (Meta) or third‑party provider.
 *
 * Usage example:
 *   $wh = new \App\Libraries\WhatsAppService();
 *   $wh->sendTemplate('+628123456789', 'transaction_alert', $components);
 */
class WhatsAppService
{
    /**
     * Base URL for Graph API (Meta WhatsApp Cloud API)
     * @var string
     */
    private $baseUrl = 'https://graph.facebook.com/v19.0/';

    /**
     * Access token (should be stored in .env as WHATSAPP_TOKEN)
     * @var string
     */
    private $token;

    /**
     * Phone Number ID (the WhatsApp Business phone number ID)
     * @var string
     */
    private $phoneId;

    public function __construct()
    {
        // Load from environment – CI will expose getenv()
        $this->token   = getenv('WHATSAPP_TOKEN');
        $this->phoneId = getenv('WHATSAPP_PHONE_ID');
    }

    /**
     * Send a template message.
     *
     * @param string $to          Recipient phone number in international format (e.g. +628123456789)
     * @param string $template    Template name that you have approved in Meta Business Manager
     * @param array  $components  Optional components (body/ header / button parameters)
     * @return bool                True on success, false otherwise
     */
    public function sendTemplate(string $to, string $template, array $components = []): bool
    {
        if (empty($this->token) || empty($this->phoneId)) {
            log_message('error', 'WhatsAppService: missing token or phone ID');
            return false;
        }

        $payload = [
            'messaging_product' => 'whatsapp',
            'to'                => $to,
            'type'              => 'template',
            'template'          => [
                'name'     => $template,
                'language' => ['code' => 'id'], // Bahasa Indonesia; ubah jika perlu
                'components'=> $components,
            ],
        ];

        $url = $this->baseUrl . $this->phoneId . '/messages';
        $ch  = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $this->token,
                'Content-Type: application/json',
            ],
            CURLOPT_POST          => true,
            CURLOPT_POSTFIELDS    => json_encode($payload),
            CURLOPT_RETURNTRANSFER=> true,
            CURLOPT_SSL_VERIFYPEER=> true,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            $res = json_decode($response, true);
            return isset($res['messages'][0]['id']);
        }

        log_message('error', 'WhatsAppService sendTemplate error: HTTP ' . $httpCode . ' Response: ' . $response);
        return false;
    }
}
?>
