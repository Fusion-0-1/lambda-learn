<?php

namespace app\model;

abstract class Announcement
{
    protected int $announcementId;
    protected string $heading;
    protected string $content;
    protected string $publishDate;

    protected function getAnnouncementData($id,$table): array
    {
        return Application::$db->select(
            table: $table,
            where: ['announcement_id'=>$id],
            limit: 1
        );
    }

    /**
     * @return int
     */
    public function getAnnouncementId(): int
    {
        return $this->announcementId;
    }

    /**
     * @return string
     */
    public function getHeading(): string
    {
        return $this->heading;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getPublishDate(): string
    {
        return $this->publishDate;
    }
}