<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;

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
     * @ORM\Column(name="picture_url", type="string", nullable=true)
     */
    protected $pictureUrl;

    /**
     * @var string
     * @ORM\Column(name="displayable_name", type="string", nullable=true)
     */
    protected $displayableName;

    /**
     * @var int
     * @ORM\Column(name="facebook_id", type="bigint", nullable=true)
     */
    protected $facebookId;

    /**
     * @var int
     * @ORM\Column(name="vkontakte_id", type="bigint", nullable=true)
     */
    protected $vkontakteId;

    /**
     * @var int
     * @ORM\Column(name="twitter_id", type="bigint", nullable=true)
     */
    protected $twitterId;

    /**
     * @var int
     * @ORM\Column(name="google_id", type="bigint", nullable=true)
     */
    protected $googleId;

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
        switch ($response->getResourceOwner()->getName()) {
            case 'facebook':
                $user->setFacebookId($response->getResponse()['id']);
                $user->setUsername('fb-' . $response->getResponse()['id']);
                $user->setDisplayableName($response->getResponse()['name']);
                $user->setEmail($response->getResponse()['email']);
                $user->setPictureUrl($response->getResponse()['picture']['data']['url']);
                break;

            case 'vkontakte':
                $responseInner = $response->getResponse()['response'][0];
                $user->setVkontakteId($responseInner['uid']);
                $user->setUsername('vk-' . $responseInner['uid']);
                $user->setDisplayableName($responseInner['first_name'] . ' ' . $responseInner['last_name']);
                $user->setEmail($response->getResponse()['email']);
                $user->setPictureUrl($responseInner['photo_medium']);
                break;

            case 'twitter':
                break;

            case 'google':
                $user->setGoogleId($response->getResponse()['id']);
                $user->setUsername('google-' . $response->getResponse()['id']);
                $user->setDisplayableName($response->getResponse()['name']);
                $user->setEmail($response->getResponse()['email']);
                $user->setPictureUrl($response->getResponse()['picture']);
                break;

            default:
                throw new \InvalidArgumentException(
                    sprintf('Resource owner `%` is not supported', $response->getResourceOwner()->getName())
                );
        }

        return $user;
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
}
