<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User extends BaseUSer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="language", type="string", nullable=true)
     */
    protected $language;

    /**
     * @var string
     * @ORM\Column(name="picture_url", type="string", nullable=true)
     */
    protected $pictureUrl;

    /**
     * @var string
     * @ORM\Column(name="displayable_name", type="string", nullable=true)
     */
    protected $displayableName;

    /**
     * @var array
     * @ORM\Column(name="likes", type="json_array", nullable=false)
     */
    protected $likes = [];

    /**
     * @var array
     * @ORM\Column(name="dislikes", type="json_array", nullable=false)
     */
    protected $dislikes = [];

    /**
     * @var array
     * @ORM\Column(name="favorite_lecture_ids", type="json_array", nullable=false)
     */
    protected $favoriteLectureIds = [];

    /**
     * @var ArrayCollection|Lecture[]
     * @ORM\ManyToMany(targetEntity="Lecture", mappedBy="usersFavorited")
     */
    protected $favoriteLectures;

    /**
     * @var int
     * @ORM\Column(name="facebook_id", type="string", length=32, nullable=true)
     */
    protected $facebookId;

    /**
     * @var int
     * @ORM\Column(name="vkontakte_id", type="string", length=32, nullable=true)
     */
    protected $vkontakteId;

    /**
     * @var int
     * @ORM\Column(name="twitter_id", type="string", length=32, nullable=true)
     */
    protected $twitterId;

    /**
     * @var int
     * @ORM\Column(name="google_id", type="string", length=32, nullable=true)
     */
    protected $googleId;

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
    
    /**
     * @param UserResponseInterface $response
     * @return User
     * @throws \InvalidArgumentException
     */
    public static function fromOAuthResponse(UserResponseInterface $response)
    {
        $user = new self;
        $user->setPassword('whatever');
        $user->setEnabled(true);
        $user->updateFromOauthResponse($response);

        return $user;
    }

    /**
     * @param UserResponseInterface $response
     * @throws \InvalidArgumentException
     */
    public function updateFromOauthResponse(UserResponseInterface $response)
    {
        switch ($response->getResourceOwner()->getName()) {
            case 'facebook':
                $this->setFacebookId($response->getUsername());
                $this->setUsername('fb-' . $response->getUsername());
                $this->setDisplayableName($response->getNickname());
                if ($response->getEmail()) {
                    $this->setEmail($response->getEmail());
                } else {
                    $this->setEmail('fb-no-email-' . md5(rand()) . '@example.com');
                }
                $this->setPictureUrl($response->getData()['picture']['data']['url']);
                break;

            case 'vkontakte':
                $responseInner = $response->getData();
                $this->setVkontakteId($responseInner['uid']);
                $this->setUsername('vk-' . $responseInner['uid']);
                $this->setDisplayableName($responseInner['first_name'] . ' ' . $responseInner['last_name']);
                if ($response->getEmail()) {
                    $this->setEmail($response->getEmail());
                } else {
                    //in VK user can hide his email, but FOS treats email as mandatory
                    $this->setEmail('vk-hidden-email-' . md5(rand()) . '@example.com');
                }
                $this->setPictureUrl($responseInner['photo_medium']);
                break;

            case 'twitter':
                $this->setTwitterId($response->getUsername());
                $this->setUsername('twitter-' . $response->getUsername());
                $this->setDisplayableName($response->getNickname());
                $this->setEmail('twitter-email-' . md5(rand()) . '@example.com');
                $this->setPictureUrl($response->getProfilePicture());
                break;

            case 'google':
                $this->setGoogleId($response->getUsername());
                $this->setUsername('google-' . $response->getUsername());
                $this->setDisplayableName($response->getNickname());
                $this->setEmail($response->getEmail());
                $this->setPictureUrl($response->getProfilePicture());
                break;

            default:
                throw new \InvalidArgumentException(
                    sprintf('Resource owner `%` is not supported', $response->getResourceOwner()->getName())
                );
        }
    }

    /** @param int $facebookId */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
    }

    /** @return int */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /** @param int $googleId */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;
    }

    /** @return int */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /** @param int $twitterId */
    public function setTwitterId($twitterId)
    {
        $this->twitterId = $twitterId;
    }

    /** @return int */
    public function getTwitterId()
    {
        return $this->twitterId;
    }

    /** @param int $vkontakteId */
    public function setVkontakteId($vkontakteId)
    {
        $this->vkontakteId = $vkontakteId;
    }

    /** @return int */
    public function getVkontakteId()
    {
        return $this->vkontakteId;
    }

    /** @param string $pictureUrl */
    public function setPictureUrl($pictureUrl)
    {
        $this->pictureUrl = $pictureUrl;
    }

    /** @return string */
    public function getPictureUrl()
    {
        return $this->pictureUrl;
    }

    /** @param string $displayableName */
    public function setDisplayableName($displayableName)
    {
        $this->displayableName = $displayableName;
    }

    /** @return string */
    public function getDisplayableName()
    {
        return $this->displayableName;
    }

    /** @param array $likes */
    public function setLikes(array $likes)
    {
        $this->likes = $likes;
    }

    /** @param array $dislikes */
    public function setDislikes(array $dislikes)
    {
        $this->dislikes = $dislikes;
    }

    /** @return \AppBundle\Entity\Lecture[]|\Doctrine\Common\Collections\ArrayCollection */
    public function getFavoriteLectures()
    {
        return $this->favoriteLectures;
    }

    /** @return array */
    public function getFavoriteLectureIds()
    {
        return $this->favoriteLectureIds;
    }

    /** @param array $favoriteLectureIds */
    public function setFavoriteLectureIds(array $favoriteLectureIds)
    {
        $this->favoriteLectureIds = $favoriteLectureIds;
    }

    /** @param Lecture $lecture */
    public function likeLecture(Lecture $lecture)
    {
        $lecture->setLikesCount($lecture->getLikesCount() + 1);
        $this->likes = array_unique(array_merge($this->likes, [$lecture->getId()]));
        $this->dislikes = array_unique(array_diff($this->dislikes, [$lecture->getId()]));
    }

    /** @param Lecture $lecture */
    public function dislikeLecture(Lecture $lecture)
    {
        $lecture->setDislikesCount($lecture->getDislikesCount() + 1);
        $this->dislikes = array_unique(array_merge($this->dislikes, [$lecture->getId()]));
        $this->likes = array_unique(array_diff($this->likes, [$lecture->getId()]));
    }

    /** @param Lecture $lecture */
    public function removeLectureReaction(Lecture $lecture)
    {
        $this->dislikes = array_unique(array_diff($this->dislikes, [$lecture->getId()]));
        $this->likes = array_unique(array_diff($this->likes, [$lecture->getId()]));
    }

    /** @param Lecture $lecture */
    public function favLecture(Lecture $lecture)
    {
        if (false === $this->favoriteLectures->contains($lecture)) {
            $this->favoriteLectures->add($lecture);
            $this->favoriteLectureIds = array_unique(array_merge(
                $this->favoriteLectureIds,
                [$lecture->getId()]
            ));
        }
        if (false === $lecture->getUsersFavorited()->contains($this)) {
            $lecture->getUsersFavorited()->add($this);
            $lecture->setFavsCount($lecture->getFavsCount() + 1);
        }
    }

    /** @param Lecture $lecture */
    public function unfavLecture(Lecture $lecture)
    {
        if ($this->favoriteLectures->contains($lecture)) {
            $this->favoriteLectures->removeElement($lecture);
            $this->favoriteLectureIds = array_unique(array_diff(
                $this->favoriteLectureIds,
                [$lecture->getId()]
            ));
        }
        if ($lecture->getUsersFavorited()->contains($this)) {
            $lecture->getUsersFavorited()->removeElement($this);
            $lecture->setFavsCount($lecture->getFavsCount() - 1);
        }
    }

    /**
     * @param Lecture $lecture
     * @return bool
     */
    public function didLectureLike(Lecture $lecture)
    {
        return in_array($lecture->getId(), $this->likes);
    }

    /**
     * @param Lecture $lecture
     * @return bool
     */
    public function didLectureDislike(Lecture $lecture)
    {
        return in_array($lecture->getId(), $this->dislikes);
    }

    /**
     * @param Lecture $lecture
     * @return bool
     */
    public function didLectureFav(Lecture $lecture)
    {
        return in_array($lecture->getId(), $this->favoriteLectureIds);
    }
}
