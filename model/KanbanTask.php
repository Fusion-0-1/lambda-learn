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
    private string $priority;
    private string $regNo;

    private function __construct() {}

    public static function createNewKanbanTask($title, $description, $state, $priority, $regNo, $dueDate='', $taskId=''): KanbanTask {
        $task = new KanbanTask();
        $task->title = $title;
        $task->description = $description;
        $task->state = $state;
        $task->priority = $priority;
        $task->regNo = $regNo;
        $task->dueDate = $dueDate;
        $task->taskId = $taskId;

        return $task;
    }

    public static function getToDoTasks(User $user): array
    {
        $kanbanTasks = [];
        $results = Application::$db->select(
            table: 'KanbanTask',
            columns: ['task_id', 'title', 'description', 'due_date', 'state', 'priority'],
            where: ['reg_no' => $user->getRegNo(), 'state' => 'To Do'],
            order: 'priority DESC, due_date ASC'
        );
        while ($kanbanTask = Application::$db->fetch($results)) {
            $kanbanTasks[] = self::createNewKanbanTask(
                title: $kanbanTask['title'],
                description: $kanbanTask['description'],
                state: $kanbanTask['state'],
                priority: $kanbanTask['priority'],
                regNo: $user->getRegNo(),
                dueDate: $kanbanTask['due_date'],
                taskId: $kanbanTask['task_id']
            );
        }
        return $kanbanTasks;
    }

    public static function getInProgressTasks(User $user): array
    {
        $kanbanTasks = [];
        $results = Application::$db->select(
            table: 'KanbanTask',
            columns: ['task_id', 'title', 'description', 'due_date', 'state', 'priority'],
            where: ['reg_no' => $user->getRegNo(), 'state' => 'In Progress'],
            order: 'priority DESC, due_date ASC'
        );
        while ($kanbanTask = Application::$db->fetch($results)) {
            $kanbanTasks[] = self::createNewKanbanTask(
                title: $kanbanTask['title'],
                description: $kanbanTask['description'],
                state: $kanbanTask['state'],
                priority: $kanbanTask['priority'],
                regNo: $user->getRegNo(),
                dueDate: $kanbanTask['due_date'],
                taskId: $kanbanTask['task_id']
            );
        }
        return $kanbanTasks;
    }

    public static function getDoneTasks(User $user): array
    {
        $kanbanTasks = [];
        $results = Application::$db->select(
            table: 'KanbanTask',
            columns: ['task_id', 'title', 'description', 'due_date', 'state', 'priority'],
            where: ['reg_no' => $user->getRegNo(), 'state' => 'Done'],
            order: 'priority DESC, due_date DESC'
        );
        while ($kanbanTask = Application::$db->fetch($results)) {
            $kanbanTasks[] = self::createNewKanbanTask(
                title: $kanbanTask['title'],
                description: $kanbanTask['description'],
                state: $kanbanTask['state'],
                priority: $kanbanTask['priority'],
                regNo: $user->getRegNo(),
                dueDate: $kanbanTask['due_date'],
                taskId: $kanbanTask['task_id']
            );
        }
        return $kanbanTasks;
    }

    public function insertKanbanTask()
    {
        Application::$db->insert(
            table: 'KanbanTask',
            values: [
                'title' => $this->title,
                'description' => $this->description,
                'state' => $this->state,
                'due_date' => $this->dueDate,
                'reg_no' => $this->regNo
            ]
        );
    }

    public static function deleteKanbanTask($taskIdDlt)
    {
        Application::$db->delete(
            table: 'KanbanTask',
            where: ['task_id' => $taskIdDlt]
        );
    }

    public function updateKanbanTask()
    {
        Application::$db->update(
            table: 'KanbanTask',
            columns: [
                'title' => $this->title,
                'description' => $this->description,
                'state' => $this->state,
                'due_date' => $this->dueDate
            ],
            where: ['task_id' => $this->taskId]
        );
    }

    public static function updateKanbanTaskState($taskId, $state)
    {
        Application::$db->update(
            table: 'KanbanTask',
            columns: [
                'state' => $state
            ],
            where: ['task_id' => $taskId]
        );
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

    /**
     * @return string
     */
    public function getPriority(): string
    {
        return $this->priority;
    }

    /**
     * @param string $priority
     */
    public function setPriority(string $priority): void
    {
        $this->priority = $priority;
    }

}