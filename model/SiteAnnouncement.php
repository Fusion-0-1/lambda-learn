<?php

namespace app\model;

use app\core\Application;

class SiteAnnouncement extends Announcement
{
    private string $adminRegNo;
    private string $cordRegNo;

    private function __construct()
    {

    }
    public static function fetchAnnFromDb(int $id){
        $table = self::getSiteAnnouncementData($id);

        $siteAnnouncement = new SiteAnnouncement();
        $siteAnnouncement->announcementId = $table['announcement_id'];
        $siteAnnouncement->heading = $table['heading'];
        $siteAnnouncement->content = $table['content'];
        $siteAnnouncement->publishDate = $table['publish_date'];
        $siteAnnouncement->adminRegNo = $table['admin_reg_no'];
        $siteAnnouncement->cordRegNo = $table['cord_reg_no'];

        return $siteAnnouncement;
    }
    public static function createNewAnn(string $heading, string $content, string $publishDate='',
                                        $adminRegNo='', $cordRegNo='', int $announcementId=null){


        $announcement = new SiteAnnouncement();
        if ($announcementId != null){
            $announcement->announcementId = $announcementId;
        }
        $announcement->heading = $heading;
        $announcement->content = $content;
        $announcement->publishDate = $publishDate;
        $announcement->adminRegNo = $adminRegNo ?? '';
        $announcement->cordRegNo = $cordRegNo ?? '';

        return $announcement;
    }
    private static function getSiteAnnouncementData($id): array
    {
        return parent::getAnnouncementData($id,'SiteAnnouncement');
    }
    public static function getSiteAnnouncements(): array
    {
        $siteAnnouncements = [];
        $results = Application::$db->select(
            table: 'SiteAnnouncement',
            order: 'announcement_id DESC'
        );
        while ($ann = Application::$db->fetch($results)){
             $siteAnnouncements[] = self::createNewAnn(
                 $ann['heading'],
                 $ann['content'],
                 $ann['publish_date'],
                 $ann['admin_reg_no'],
                 $ann['cord_reg_no'],
                 (int)$ann['announcement_id'],
             );
        }

        return $siteAnnouncements;
    }

    //---------------Insert SiteAnnouncement------------------

    public function insert()
    {
        date_default_timezone_set('Asia/Colombo');
        Application::$db->insert(
            table: 'SiteAnnouncement',
            values: [
                'heading' => $this->heading,
                'content' => $this->content,
                'publish_date' => $this->publishDate ?: date('Y-m-d H:i:s'),
                'admin_reg_no' => $this->adminRegNo ?? '',
                'cord_reg_no' => $this->cordRegNo ?? ''
            ]
        );
    }

    /**
     * @return string
     */
    public function getAdminRegNo(): string
    {
        return $this->adminRegNo;
    }

    /**
     * @return string
     */
    public function getCordRegNo(): string
    {
        return $this->cordRegNo;
    }

}