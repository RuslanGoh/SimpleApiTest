<?php

namespace Controllers;

class MainController
{
    public function form()
    {
        include __DIR__ . '/../../public/form.php';
    }

    public function list()
    {
        include __DIR__ . '/../../public/list.php';
    }
}