<?php

namespace app\controllers;

use app\core\Controller;

class Kanbanboard extends Controller
{
    public function displayKanbanboard()
    {
        return $this->render(
            view: '/kanbanboard',
            allowedRoles: ['Lecturer', 'Student']
        );
    }
}