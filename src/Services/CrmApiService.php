<?php

namespace Services;

use Requests\LeadRequest;

class CrmApiService
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function sendLead(LeadRequest $leadRequest)
    {
        $data = [
            'firstName' => $leadRequest->firstName,
            'lastName' => $leadRequest->lastName,
            'phone' => $leadRequest->phone,
            'email' => $leadRequest->email,
            'countryCode' => $this->config['countryCode'] ?? '',
            'box_id' => $this->config['box_id'] ?? '',
            'offer_id' => $this->config['offer_id'] ?? '',
            'landingUrl' => $this->config['landingUrl'] ?? '',
            'ip' => $this->config['ip'] ?? '',
            'password' => $this->config['password'] ?? '',
            'language' => $this->config['language'] ?? '',
            'clickId' => $this->config['clickId'] ?? '',
            'quizAnswers' => $this->config['quizAnswers'] ?? '',
        ];

        return $this->request('/addlead', $data);
    }

    public function getLeadStatuses(string $dateFrom = '', string $dateTo = '', int $page = 0, int $limit = 100)
    {
        $data = [
            'date_from' => $dateFrom ?: date('Y-m-d H:i:s', strtotime('-30 days')),
            'date_to' => $dateTo ?: date('Y-m-d H:i:s'),
            'page' => $page,
            'limit' => $limit,
        ];

        return $this->request('/getstatuses', $data);
    }

    private function request(string $endpoint, array $data): array
    {
        $url = rtrim($this->config['crm_url'], '/') . '/' . ltrim($endpoint, '/');

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'token: ' . $this->config['token'],
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        return is_array($result) ? $result : [];
    }
}