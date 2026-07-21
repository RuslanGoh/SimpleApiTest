<?php

namespace Controllers;

class MainController
{
    public function form()
    {
        include __DIR__ . '/../../public/form.php';
    }

    public function list(\Services\CrmApiService $leadService)
    {
        $statusRequest = new \Requests\StatusRequest($_GET);
        $errors = $statusRequest->validate();

        $leads = [];
        $error = null;

        if (!empty($errors)) {
            $error = 'Validation error: ' . implode(', ', $errors);
        } else {
            $statuses = $leadService->getLeadStatuses(
                $statusRequest->getDateFromFormatted(),
                $statusRequest->getDateToFormatted(),
                $statusRequest->page,
                $statusRequest->limit
            );

            $error = $statuses['error'] ?? ($statuses['message'] ?? null);
            if (isset($statuses['data'])) {
                $leads = $statuses['data'];
            }
        }

        $dateFrom = $statusRequest->dateFrom;
        $dateTo = $statusRequest->dateTo;
        $page = $statusRequest->page;
        
        $prevPageUrl = $page > 0 ?
            'list?' . http_build_query(array_merge($_GET, ['page' => $page - 1])) :
            null;
        //@TODO fix last page issue
        //Need more data from the API to avoid an empty last page when count($leads) == $limit and this is the last page
        $nextPageUrl = count($leads) >= $statusRequest->limit ?
            'list?' . http_build_query(array_merge($_GET, ['page' => $page + 1])) :
            null;

        include __DIR__ . '/../../public/list.php';
    }
}