<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\model\KanbanTask;
use app\core\User;
use app\model\Submission;

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
        $kanbanTask = KanbanTask::createNewKanbanTask(
            title: $body['card-header'],
            description: $body['card-body'],
            state: $body['card-status'],
            priority: $body['card-priority'],
            regNo: $user->getRegNo(),
            dueDate: $body['card-deadline']
            );
        $kanbanTask->insertKanbanTask();
        header("Location: /kanbanboard");
    }

    public function deleteKanbanTasks(Request $request)
    {
        $body = $request->getBody();
        KanbanTask::deleteKanbanTask($body['card-delete-id']);
        header("Location: /kanbanboard");
    }

    public function updateKanbanTasks(Request $request)
    {
        $body = $request->getBody();
        $user = unserialize($_SESSION['user']);
        $kanbanTask = KanbanTask::createNewKanbanTask(
            title: $body['card-header'],
            description: $body['card-body'],
            state: $body['card-state'],
            priority: $body['card-priority'],
            regNo: $user->getRegNo(),
            dueDate: $body['card-deadline'],
            taskId: $body['card-id']
        );
        $kanbanTask->updateKanbanTask();
        header("Location: /kanbanboard");
    }

    public function updateKanbanTasksState(Request $request)
    {
        $body = $request->getBody();
        KanbanTask::updateKanbanTaskState($body['card-id'], $body['card-state']);
    }

    public function displayCalender()
    {
        $user = unserialize($_SESSION['user']);
        if ($_SESSION['user-role'] == 'Student') {
            $params['submissions'] = Submission::getUserSubmissions($user);
            return $this->render(
                view: '/calender',
                params: $params
            );
        } else if ($_SESSION['user-role'] == 'Lecturer') {
            $params['tasks'] = KanbanTask::getToDoTasks($user);
            return $this->render(
                view: '/calender',
                params: $params
            );
        } else {
            return $this->render(
                view: '/calender'
            );
        }
    }
}