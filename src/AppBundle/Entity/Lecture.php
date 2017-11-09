<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\LectureRepository")
 * @ORM\Table(name="lecture")
 */
class Lecture
{
    const EMBEDDABLE_URL_PREFIX = 'https://youtube.com/embed/';
    const FULL_URL_PREFIX = 'https://youtube.com/watch/?v=';
    const THUMBNAIL_URL_PREFIX = 'https://i.ytimg.com/vi/';
    const THUMBNAIL_URL_SUFFIX = '/mqdefault.jpg';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $created;

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

    /**
     * @ORM\ManyToMany(targetEntity="SubtitlesLanguage")
     * @ORM\JoinTable(
     *     joinColumns={@ORM\JoinColumn(name="lecture_id", referencedColumnName="id", onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="subtitles_language_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    protected $subtitlesLanguages;

    /**
     * @ORM\Column(name="language", type="string", length=3, nullable=false, options={"default": "ru"})
     */
    protected $language;

    /**
     * @ORM\Column(name="random_rating", type="integer", nullable=false)
     */
    protected $randomRating = 500;

    /**
     * @var int
     * @ORM\Column(name="likes_count", type="integer", nullable=false)
     */
    protected $likesCount = 0;

    /**
     * @var int
     * @ORM\Column(name="dislikes_count", type="integer", nullable=false)
     */
    protected $dislikesCount = 0;

    /**
     * @var int
     * @ORM\Column(name="comments_count", type="integer", nullable=false)
     */
    protected $commentsCount = 0;

    /**
     * @var int
     * @ORM\Column(name="favs_count", type="integer", nullable=false)
     */
    protected $favsCount = 0;

    /**
     * @ORM\Column(name="is_featured", type="boolean", nullable=false)
     */
    protected $isFeatured = false;

    /**
     * @var ArrayCollection|User[]
     * @ORM\ManyToMany(targetEntity="User", inversedBy="favoriteLectures")
     */
    protected $usersFavorited;

    public function __construct()
    {
        $this->created = new \DateTime();
    }

    /**
     * @param LectureAnnouncement $announcement
     * @return self
     */
    public static function fromAnnouncement(LectureAnnouncement $announcement)
    {
        $lecture = new self;
        $lecture->setTitle($announcement->getTitle());
        $lecture->setTeaser($announcement->getTeaser());
        $lecture->setLecturer($announcement->getLecturer());
        $lecture->setField($announcement->getField());
        $lecture->setLanguage($announcement->getLanguage());
        
        return $lecture;
    }
    
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

    /** @return string */
    public function getLanguage()
    {
        return $this->language;
    }

    /** @param string $language */
    public function setLanguage($language)
    {
        $this->language = $language;
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

    /** @return SubtitlesLanguage[] */
    public function getSubtitlesLanguages()
    {
        return $this->subtitlesLanguages;
    }

    /** @param SubtitlesLanguage[] $subtitlesLanguages */
    public function setSubtitlesLanguages($subtitlesLanguages)
    {
        $this->subtitlesLanguages = $subtitlesLanguages;
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

    /** @return string */
    public function getVideoThumbnailUrl()
    {
        return self::THUMBNAIL_URL_PREFIX . $this->getVideoId() . self::THUMBNAIL_URL_SUFFIX;
    }

    /** @return int */
    public function getRandomRating()
    {
        return $this->randomRating;
    }

    /** @param int $randomRating */
    public function setRandomRating($randomRating)
    {
        $this->randomRating = $randomRating;
    }

    /** @return bool */
    public function getIsFeatured()
    {
        return $this->isFeatured;
    }

    /** @param bool $isFeatured */
    public function setIsFeatured($isFeatured)
    {
        $this->isFeatured = $isFeatured;
    }

    /** @return string */
    public function getVideoId()
    {
        return str_replace(
            self::EMBEDDABLE_URL_PREFIX,
            "",
            $this->getVideoUrl()
        );
    }

    /** @param int $dislikesCount */
    public function setDislikesCount($dislikesCount)
    {
        $this->dislikesCount = $dislikesCount;
    }

    /** @return int */
    public function getDislikesCount()
    {
        return $this->dislikesCount;
    }

    /** @param int $likesCount */
    public function setLikesCount($likesCount)
    {
        $this->likesCount = $likesCount;
    }

    /** @return int */
    public function getLikesCount()
    {
        return $this->likesCount;
    }

    /** @param int $favsCount */
    public function setFavsCount($favsCount)
    {
        $this->favsCount = $favsCount;
    }

    /** @return int */
    public function getFavsCount()
    {
        return $this->favsCount;
    }

    /** @return User[]|ArrayCollection */
    public function getUsersFavorited()
    {
        return $this->usersFavorited;
    }

    /** @param int $commentsCount */
    public function setCommentsCount($commentsCount)
    {
        $this->commentsCount = $commentsCount;
    }

    /** @return int */
    public function getCommentsCount()
    {
        return $this->commentsCount;
    }

    /**
     * @param string $watchUrl
     * @return string
     */
    private function getEmbeddableUrl($watchUrl)
    {
        if (strpos($watchUrl, self::EMBEDDABLE_URL_PREFIX) === 0) {
            // already embeddable
            return $watchUrl;
        }

        $query = parse_url($watchUrl, PHP_URL_QUERY);
        parse_str($query, $queryParsed);
        if (isset($queryParsed['v'])) {
            //URL like youtube.com/watch?v=123123
            return self::EMBEDDABLE_URL_PREFIX . $queryParsed['v'];
        }
        //URL like youtu.be/123123
        return self::EMBEDDABLE_URL_PREFIX . parse_url($watchUrl, PHP_URL_PATH);
    }
}
