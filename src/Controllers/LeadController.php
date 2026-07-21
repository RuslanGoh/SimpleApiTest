<?php

namespace Controllers;

class LeadController
{
    public function store(\Services\CrmApiService $leadService)
    {
        header('Content-Type: application/json');

        $token = $_POST['csrf_token'] ?? '';
        if (empty($token) || $token !== ($_SESSION['csrf_token'] ?? '')) {
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
            return;
        }

        $lastSubmission = $_SESSION['last_submission_time'] ?? 0;
        if (time() - $lastSubmission < 5) {
            echo json_encode(['success' => false, 'message' => 'Too many requests. Please wait 5 seconds.']);
            return;
        }
        $_SESSION['last_submission_time'] = time();

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