<?php

namespace app\model;

use app\core\Application;

/**
 *
 */
class CourseAnnouncement extends Announcement
{
    private static string $tableName = "CourseAnnouncement";
    private string $lecRegNo;
    private string $courseCode;

    private function __construct(){}
    public static function fetchAnnFromDb(int $id){
        $courseAnnouncement = new CourseAnnouncement();
        $table = self::getCourseAnnouncementData($id);

        $courseAnnouncement->announcementId = $table['announcement_id'];
        $courseAnnouncement->heading = $table['heading'];
        $courseAnnouncement->content = $table['content'];
        $courseAnnouncement->publishDate = $table['publish_date'];
        $courseAnnouncement->lecRegNo = $table['lec_reg_no'];
        $courseAnnouncement->courseCode = $table['course_code'];
        return $courseAnnouncement;
    }

    public static function createNewAnn(string $heading, string $content, string $lecRegNo, string $courseCode, int $announcementId=null, string $publishDate=''){
        $announcement = new CourseAnnouncement();
        if ($announcementId != null){
            $announcement->announcementId = $announcementId;
        }
        $announcement->heading = $heading;
        $announcement->content = $content;
        $announcement->publishDate = $publishDate;
        $announcement->lecRegNo = $lecRegNo;
        $announcement->courseCode = $courseCode;

        return $announcement;
    }

    //--------------------Display Course-announcement------------------------------

    /**
     * @description Get course announcement data from database
     * @param $id
     * @return array
     */
    private static function getCourseAnnouncementData($id): array
    {
        return parent::getAnnouncementData($id, self::$tableName);
    }

    /**
     * @description Get all course announcements from database for a given course
     * @param $course_code
     * @return array
     */
    public static function getCourseAnnouncements($course_code): array
    {
        $courseAnnouncements = [];
        $results = Application::$db->select(
            table: self::$tableName,
            where: ['course_code' => $course_code],
            order: 'announcement_id DESC'
        );
        while ($ann = Application::$db->fetch($results)){
            $courseAnnouncements[] = self::createNewAnn(
                $ann['heading'],
                $ann['content'],
                $ann['lec_reg_no'] ,
                $ann['course_code'] ,
                (int)$ann['announcement_id'],
                $ann['publish_date']
            );
        }

        return $courseAnnouncements;
    }

    //---------------Insert CourseAnnouncement------------------

    /**
     * @description Insert course announcement data into database
     * @return void
     */
    public function CourseAnnouncementInsert()
    {
        Application::$db->insert(
            table: self::$tableName,
            values: [
                'heading' => $this->heading,
                'content' => $this->content,
                'publish_date' => $this->publishDate ?: date('Y-m-d H:i:s'),
                'lec_reg_no' => $this->lecRegNo,
                'course_code' => $this->courseCode ?? ''
            ]
        );
    }

    /**
     * @description Update course announcement data in database
     * @param $announcementId
     * @param $heading
     * @param $content
     * @return void
     */
    public static function CourseAnnouncementsUpdate($announcementId, $heading, $content)
    {
        Application::$db->update(
            table: self::$tableName,
            columns: ['heading'=>$heading,'content'=>$content],
            where: ['announcement_id'=>$announcementId]
        );
    }

    /**
     * @description Delete course announcement data from database
     * @param $announcementId
     * @param $courseCode
     * @return void
     */
    public static function deleteCourseAnnouncement($announcementId, $courseCode)
    {
        Application::$db->delete(
            table: self::$tableName,
            where: ['announcement_id'=>$announcementId,'course_code' => $courseCode]
        );
    }

    /**
     * @description Delete all course announcements of a course from database
     */
    public static function truncateCourseAnnouncements()
    {
        Application::$db->truncateTable(self::$tableName);
    }
    
    /**
     * @return string
     */
    public function getLecRegNo(): string
    {
        return $this->lecRegNo;
    }

    /**
     * @return string
     */
    public function getCourseCode(): string
    {
        return $this->courseCode;
    }

}