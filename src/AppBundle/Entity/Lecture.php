<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\LectureRepository")
 * @ORM\Table(name="lecture")
 */
class Lecture
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="title", type="string", length=127, nullable=false)
     */
    protected $title;

    /**
     * @ORM\Column(name="teaser", type="text", nullable=false)
     */
    protected $teaser;

    /**
     * @ORM\Column(name="video_id", type="text", nullable=false)
     */
    protected $videoId;

    /**
     * @ORM\Column(name="discussion_video_id", type="text", nullable=false)
     */
    protected $discussionVideoId;

    /**
     * @var Lecturer
     * @ORM\ManyToOne(
     *  targetEntity="Lecturer",
     *  inversedBy="lectures"
     * )
     * @ORM\JoinColumn(name="lecturer_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $lecturer;

    /**
     * @var Field
     * @ORM\ManyToOne(
     *   targetEntity="Field",
     *   inversedBy="lectures"
     * )
     * @ORM\JoinColumn(name="field_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $field;

    /**
     * @var Event
     * @ORM\ManyToOne(
     *  targetEntity="Event",
     *  inversedBy="lectures"
     * )
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $event;

    /**
     * @ORM\ManyToMany(targetEntity="Tag")
     * @ORM\JoinTable(name="tag_lecture",
     *     joinColumns={@ORM\JoinColumn(name="lecture_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     * )
     */
    protected $tags;

    /** @return int */
    public function getId()
    {
        return $this->id;
    }

    /** @return string */
    public function getTitle()
    {
        return $this->title;
    }

    /** @param string $title */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /** @return string */
    public function getTeaser()
    {
        return $this->teaser;
    }

    /** @param string $teaser */
    public function setTeaser($teaser)
    {
        $this->teaser = $teaser;
    }

    /** @return Lecturer */
    public function getLecturer()
    {
        return $this->lecturer;
    }

    /** @param Lecturer $lecturer */
    public function setLecturer(Lecturer $lecturer)
    {
        $this->lecturer = $lecturer;
    }

    /** @return Event */
    public function getEvent()
    {
        return $this->event;
    }

    /** @param Event $event */
    public function setEvent(Event $event)
    {
        $this->event = $event;
    }

    /** @return City */
    public function getCity()
    {
        return $this->getEvent()->getCity();
    }

    /** @return string */
    public function getDate()
    {
        return $this->getEvent()->getDate();
    }

    /** @return Field */
    public function getField()
    {
        return $this->field;
    }

    /** @param Field $field */
    public function setField(Field $field)
    {
        $this->field = $field;
    }

    /** @return string */
    public function getVideoId()
    {
        return $this->videoId;
    }

    /** @param string $videoId */
    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;
    }

    /** @return Tag[] */
    public function getTags()
    {
        return $this->tags;
    }

    /** @return string */
    public function getDiscussionVideoId()
    {
        return $this->discussionVideoId;
    }

    /** @param string $discussionVideoId */
    public function setDiscussionVideoId($discussionVideoId)
    {
        $this->discussionVideoId = $discussionVideoId;
    }
}
