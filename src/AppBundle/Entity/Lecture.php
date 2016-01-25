<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\LectureRepository")
 * @ORM\Table(name="lecture")
 */
class Lecture
{
    const EMBEDDABLE_URL_PREFIX = 'https://youtube.com/embed/';
    const FULL_URL_PREFIX = 'https://youtube.com/watch/?v=';

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
     * @ORM\Column(name="video_url", type="string", length=127, nullable=false, unique=true)
     */
    protected $videoUrl;

    /**
     * @ORM\Column(name="discussion_video_url", type="string", length=127, nullable=true)
     */
    protected $discussionVideoUrl;

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
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="lectures")
     * @ORM\JoinTable(
     *     joinColumns={@ORM\JoinColumn(name="lecture_id", referencedColumnName="id", onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    protected $tags;

    /** {@inheritdoc} */
    public function __toString()
    {
        return $this->getTitle();
    }

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
    public function getVideoUrl()
    {
        return $this->videoUrl;
    }

    /** @param string $videoUrl */
    public function setVideoUrl($videoUrl)
    {
        $this->videoUrl = $this->getEmbeddableUrl($videoUrl);
    }

    /** @param Tag[] $tags */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /** @return Tag[] */
    public function getTags()
    {
        return $this->tags;
    }

    /** @return string */
    public function getDiscussionVideoUrl()
    {
        return $this->discussionVideoUrl;
    }

    /** @param string $discussionVideoUrl */
    public function setDiscussionVideoUrl($discussionVideoUrl)
    {
        $this->discussionVideoUrl = $this->getEmbeddableUrl($discussionVideoUrl);
    }

    /** @return string */
    public function getDiscussionVideoFullUrl()
    {
        return str_replace(
            self::EMBEDDABLE_URL_PREFIX,
            self::FULL_URL_PREFIX,
            $this->discussionVideoUrl
        );
    }

    /** @return bool */
    public function hasDiscussionVideo()
    {
        return (bool)$this->discussionVideoUrl;
    }

    /**
     * @param string $watchUrl
     * @return string
     */
    private function getEmbeddableUrl($watchUrl)
    {
        if (strpos($watchUrl, self::EMBEDDABLE_URL_PREFIX) === 0) {
            return $watchUrl;
        }

        $query = parse_url(($watchUrl), PHP_URL_QUERY);
        parse_str($query, $queryParsed);

        return self::EMBEDDABLE_URL_PREFIX . $queryParsed['v'];
    }
}
