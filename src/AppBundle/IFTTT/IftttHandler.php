<?php

namespace AppBundle\IFTTT;

use AppBundle\Entity\Announcement;

class IftttHandler
{
    /** @param Announcement $announcement */
    public static function handleAnnouncement(Announcement $announcement)
    {
        if ($key = $announcement->getCity()->getIftttKey()) {
            $topics = "";
            foreach ($announcement->getLectures() as $lecture) {
                $topics .= sprintf("%s - %s<br/>", $lecture->getLecturer()->getName(), $lecture->getTitle());
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, q);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
            curl_setopt($ch, CURLOPT_URL,"https://maker.ifttt.com/trigger/announcement/with/key/" . $key);
            curl_setopt(
                $ch,
                CURLOPT_POSTFIELDS,
                json_encode([
                    "value1" => $announcement->getDate()->format("d.m.Y"),
                    "value2" => $topics,
                    "value3" => $announcement->getWhere(),
                ])
            );

            curl_exec($ch);
            curl_close($ch);
        }
    }
}
