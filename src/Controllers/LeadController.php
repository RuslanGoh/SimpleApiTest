<?php

namespace Controllers;

class LeadController
{
    public function store(\Services\CrmApiService $leadService)
    {
        header('Content-Type: application/json');
        $leadRequest = new \Requests\LeadRequest($_POST);
        
        $errors = $leadRequest->validate();
        if (!empty($errors)) {
            echo json_encode([
                'success' => false,
                'message' => 'Validation error: ' . implode(', ', $errors),
                'errors' => $errors
            ]);
            return;
        }

        $response = $leadService->sendLead($leadRequest);
        
        $status = $response['status'] ?? false;
        
        echo json_encode([
            'success' => $status,
            'message' => $status ? 'Lead successfully sent!' : ($response['error'] ?? 'Error sending lead'),
            'data' => $response
        ]);
    }
}