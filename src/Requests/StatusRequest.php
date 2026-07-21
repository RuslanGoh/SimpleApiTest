<?php

namespace Requests;

class StatusRequest extends BaseRequest
{
    public string $dateFrom;
    public string $dateTo;
    public int $page;
    public int $limit;

    public function __construct(array $data)
    {
        $this->dateFrom = $this->sanitize($data['date_from'] ?? '');
        $this->dateTo = $this->sanitize($data['date_to'] ?? '');

        if (empty($this->dateFrom) && empty($this->dateTo)) {
            $this->dateTo = date('Y-m-d');
        }

        $this->page = isset($data['page']) ? max(0, (int)$data['page']) : 0;
        $this->limit = isset($data['limit']) ? (int)$data['limit'] : 100;
    }

    public function validate(): array
    {
        $errors = [];
        
        if (!empty($this->dateFrom) && !strtotime($this->dateFrom)) {
            $errors[] = 'Invalid date_from format';
        }

        if (!empty($this->dateTo) && !strtotime($this->dateTo)) {
            $errors[] = 'Invalid date_to format';
        }

        if ($this->limit < 1 || $this->limit > 500) {
            $errors[] = 'Limit must be between 1 and 500';
        }

        if (!empty($this->dateFrom) && !empty($this->dateTo)) {
            $from = strtotime($this->dateFrom);
            $to = strtotime($this->dateTo);
            if ($from && $to) {
                $diff = abs($to - $from);
                $days = floor($diff / (60 * 60 * 24));
                if ($days > 60) {
                    $errors[] = 'The difference between date_from and date_to must not exceed 60 days';
                }
            }
        }

        return $errors;
    }

    public function getDateFromFormatted(): string
    {
        return $this->dateFrom ? date('Y-m-d 00:00:00', strtotime($this->dateFrom)) : '';
    }

    public function getDateToFormatted(): string
    {
        return $this->dateTo ? date('Y-m-d 23:59:59', strtotime($this->dateTo)) : '';
    }
}
