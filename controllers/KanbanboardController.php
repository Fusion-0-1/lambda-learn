<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\model\KanbanTask;
use app\core\User;
use app\model\Submission;

class KanbanboardController extends Controller
{
    /**
     * @description Display kanbanboard with all tasks
     * @return array|false|string|string[]
     */
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

    /**
     * @description Insert new kanban task
     * @param Request $request
     * @return void
     */
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

    /**
     * @description Delete kanban task
     * @param Request $request
     * @return void
     */
    public function deleteKanbanTasks(Request $request)
    {
        $body = $request->getBody();
        KanbanTask::deleteKanbanTask($body['card-delete-id']);
        header("Location: /kanbanboard");
    }

    /**
     * @description Update kanban task
     * @param Request $request
     * @return void
     */
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

    /**
     * @description Update kanban task state
     * @param Request $request
     * @return void
     */
    public function updateKanbanTasksState(Request $request)
    {
        $body = $request->getBody();
        KanbanTask::updateKanbanTaskState($body['card-id'], $body['card-state']);
    }

    //-------------------------------- Calender --------------------------------------------------

    /**
     * @description Display calender
     * @return array|false|string|string[]
     */
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