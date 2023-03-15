<?php

namespace app\model;

use app\core\Application;
use app\core\User;

class KanbanTask
{

    private string $taskId;
    private string $title;
    private string $description;
    private string $dueDate;
    private string $state;
//    private string $stu_reg_no;
//    private string $lec_reg_no;

    private function __construct() {}

    public static function createNewKanbanTask($taskId, $title, $description,
                                               $dueDate='', $state): KanbanTask {
        $task = new KanbanTask();
        $task->taskId = $taskId;
        $task->title = $title;
        $task->description = $description;
        $task->dueDate = $dueDate;
        $task->state = $state;
//        $task->stu_reg_no = $stu_reg_no;
//        $task->lec_reg_no = $lec_reg_no;
        return $task;
    }

    public static function getTasks(User $user): array
    {

        $toDoTasks = self::getToDoTasks($user);
        $inProgressTasks = self::getInProgressTasks($user);
        $doneTasks = self::getDoneTasks($user);
    }

    public static function getToDoTasks(User $user): array
    {
        $kanbanTasks = [];
        $type = $user::getUserType($user->getRegNo());
        if ($type == 'Student') {
            $results = Application::$db->select(
                table: 'KanbanTask',
                columns: ['task_id', 'title', 'description', 'due_date', 'state'],
                where: ['stu_reg_no' => $user->getRegNo(), 'state' => 'To Do'],
                order: ['due_date' => 'ASC']
            );
        } elseif ($type == 'Lecturer') {
            $results = Application::$db->select(
                table: 'KanbanTask',
                columns: ['task_id', 'title', 'description', 'due_date', 'state'],
                where: ['lec_reg_no' => $user->getRegNo(), 'state' => 'To Do'],
                order: ['due_date' => 'ASC']
            );
        }
        while ($kanbanTask = Application::$db->fetch($results)) {
            $kanbanTasks[] = self::createNewKanbanTask(
                taskId: $kanbanTask['task_id'],
                title: $kanbanTask['title'],
                description: $kanbanTask['description'],
                dueDate: $kanbanTask['due_date'],
                state: $kanbanTask['state']
            );
        }
        return $kanbanTasks;
    }

    public static function getInProgressTasks(User $user): array
    {
        $kanbanTasks = [];
        $type = $user::getUserType($user->getRegNo());
        if ($type == 'Student') {
            $results = Application::$db->select(
                table: 'KanbanTask',
                columns: ['task_id', 'title', 'description', 'due_date', 'state'],
                where: ['stu_reg_no' => $user->getRegNo(), 'state' => 'In Progress'],
                order: ['due_date' => 'ASC']
            );
        } elseif ($type == 'Lecturer') {
            $results = Application::$db->select(
                table: 'KanbanTask',
                columns: ['task_id', 'title', 'description', 'due_date', 'state'],
                where: ['lec_reg_no' => $user->getRegNo(), 'state' => 'In Progress'],
                order: ['due_date' => 'ASC']
            );
        }
        while ($kanbanTask = Application::$db->fetch($results)) {
            $kanbanTasks[] = self::createNewKanbanTask(
                taskId: $kanbanTask['task_id'],
                title: $kanbanTask['title'],
                description: $kanbanTask['description'],
                dueDate: $kanbanTask['due_date'],
                state: $kanbanTask['state']
            );
        }
        return $kanbanTasks;
    }

    public static function getDoneTasks(User $user): array
    {
        $kanbanTasks = [];
        $type = $user::getUserType($user->getRegNo());
        if ($type == 'Student') {
            $results = Application::$db->select(
                table: 'KanbanTask',
                columns: ['task_id', 'title', 'description', 'due_date', 'state'],
                where: ['stu_reg_no' => $user->getRegNo(), 'state' => 'Done'],
                order: ['due_date' => 'ASC']
            );
        } elseif ($type == 'Lecturer') {
            $results = Application::$db->select(
                table: 'KanbanTask',
                columns: ['task_id', 'title', 'description', 'due_date', 'state'],
                where: ['lec_reg_no' => $user->getRegNo(), 'state' => 'Done'],
                order: ['due_date' => 'ASC']
            );
        }
        while ($kanbanTask = Application::$db->fetch($results)) {
            $kanbanTasks[] = self::createNewKanbanTask(
                taskId: $kanbanTask['task_id'],
                title: $kanbanTask['title'],
                description: $kanbanTask['description'],
                dueDate: $kanbanTask['due_date'],
                state: $kanbanTask['state']
            );
        }
        return $kanbanTasks;
    }

    // ---------------------------Getters and Setters-----------------------------------

    /**
     * @return string
     */
    public function getTaskId(): string
    {
        return $this->taskId;
    }

    /**
     * @param string $taskId
     */
    public function setTaskId(string $taskId): void
    {
        $this->taskId = $taskId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDueDate(): string
    {
        return $this->dueDate;
    }

    /**
     * @param string $dueDate
     */
    public function setDueDate(string $dueDate): void
    {
        $this->dueDate = $dueDate;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState(string $state): void
    {
        $this->state = $state;
    }

}