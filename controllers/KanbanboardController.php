<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\model\KanbanTask;
use app\core\User;

class KanbanboardController extends Controller
{
    public function displayKanbanboard()
    {
        $user = unserialize($_SESSION['user']);
        $params['toDo'] = KanbanTask::getToDoTasks($user);
        $params['inProgress'] = KanbanTask::getInProgressTasks($user);
        $params['done'] = KanbanTask::getDoneTasks($user);
        return $this->render(
            view: '/kanbanboard',
            allowedRoles: ['Lecturer', 'Student'],
            params: $params
        );
    }

    public function insertKanbanTasks(Request $request)
    {
        $body = $request->getBody();
        $user = unserialize($_SESSION['user']);
        $type = $user::getUserType($user->getRegNo());
        if ($type == 'Student') {
            $kanbanTask = KanbanTask::createNewKanbanTask(
                title: $body['card-header'],
                description: $body['card-body'],
                state: $body['card-status'],
                dueDate: $body['card-deadline'],
                stu_reg_no: $user->getRegNo()
            );
        } elseif ($type == 'Lecturer') {
            $kanbanTask = KanbanTask::createNewKanbanTask(
                title: $body['card-header'],
                description: $body['card-body'],
                state: $body['card-status'],
                dueDate: $body['card-deadline'],
                lec_reg_no: $user->getRegNo()
            );
        }
        $kanbanTask->insertKanbanTask();
        header("Location: /kanbanboard");
    }

    public function deleteKanbanTasks(Request $request)
    {
        $body = $request->getBody();

        KanbanTask::deleteKanbanTask($body['card-delete']);
        header("Location: /kanbanboard");
    }

    public function updateKanbanTasks(Request $request)
    {
        $body = $request->getBody();
        $kanbanTask = KanbanTask::createNewKanbanTask(
            title: $body['card-header'],
            description: $body['card-body'],
            state: $body['card-state'],
            dueDate: $body['card-deadline'],
            taskId: $body['card-id']
        );
        $kanbanTask->updateKanbanTask();
        header("Location: /kanbanboard");
    }
}