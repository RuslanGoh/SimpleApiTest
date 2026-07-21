<?php

namespace Requests;

class LeadRequest extends BaseRequest
{
    public string $firstName;
    public string $lastName;
    public string $phone;
    public string $email;

    public function __construct(array $data)
    {
        $this->firstName = $this->sanitize($data['firstName'] ?? '');
        $this->lastName = $this->sanitize($data['lastName'] ?? '');
        $this->phone = $this->sanitize($data['phone'] ?? '');
        $this->email = $this->sanitize($data['email'] ?? '');
    }

    public function validate(): array
    {
        $errors = [];

        if (empty($this->firstName)) {
            $errors[] = 'First name is required';
        }

        if (empty($this->lastName)) {
            $errors[] = 'Last name is required';
        }

        if (empty($this->phone)) {
            $errors[] = 'Phone is required';
        } elseif (!preg_match('/^\+?[0-9]{7,15}$/', $this->phone)) {
            $errors[] = 'Invalid phone format +1234567890';
        }

        if (empty($this->email)) {
            $errors[] = 'Email is required';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }

        return $errors;
    }
}