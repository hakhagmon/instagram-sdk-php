<?php

namespace Instagram\Response\Model;

class User extends Model
{
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    const GENDER_NOT_SPECIFIED = 3;

    protected $id;
    protected $username;
    protected $full_name;
    protected $profile_pic_url;
    protected $biography;
    protected $followersCount;
    protected $followingCount;
    protected $media;
    protected $is_private;
    protected $email;
    protected $gender;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->full_name;
    }

    /**
     * @param mixed $full_name
     */
    public function setFullName($full_name)
    {
        $this->full_name = $full_name;
    }

    /**
     * @return mixed
     */
    public function getProfilePicUrl()
    {
        return $this->profile_pic_url;
    }

    /**
     * @param mixed $profile_pic_url
     */
    public function setProfilePicUrl($profile_pic_url)
    {
        $this->profile_pic_url = $profile_pic_url;
    }

    /**
     * @return mixed
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * @param mixed $biography
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;
    }

    /**
     * @return mixed
     */
    public function getFollowersCount()
    {
        return $this->followersCount;
    }

    /**
     * @param mixed $followersCount
     */
    public function setFollowersCount($followersCount)
    {
        $this->followersCount = $followersCount;
    }

    /**
     * @return mixed
     */
    public function getFollowingCount()
    {
        return $this->followingCount;
    }

    /**
     * @param mixed $followingCount
     */
    public function setFollowingCount($followingCount)
    {
        $this->followingCount = $followingCount;
    }

    /**
     * @return mixed
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param mixed $media
     */
    public function setMedia($media)
    {
        $this->media = $media;
    }

    /**
     * @return mixed
     */
    public function getIsPrivate()
    {
        return $this->is_private;
    }

    /**
     * @param mixed $is_private
     */
    public function setIsPrivate($is_private)
    {
        $this->is_private = $is_private;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }
}