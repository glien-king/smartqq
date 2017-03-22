<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Entity;

class GroupMember
{
    /**
     * flag，作用不明
     * @var int
     */
    protected $flag;

    /**
     * 昵称
     * @var string
     */
    protected $nick;

    /**
     * 省
     * @var string
     */
    protected $province;

    /**
     * 性别
     * @var string
     */
    protected $gender;

    /**
     * 编号
     * @var int
     */
    protected $uin;

    /**
     * 国家
     * @var string
     */
    protected $country;

    /**
     * 城市
     * @var string
     */
    protected $city;

    /**
     * 群名片
     * @var string
     */
    protected $card;

    /**
     * 是否是vip
     * @var string
     */
    protected $isVip;

    /**
     * vip等级
     * @var int
     */
    protected $vipLevel;

    /**
     * @return string
     */
    public function getNick()
    {
        return $this->nick;
    }

    /**
     * @param string $nick
     */
    public function setNick($nick)
    {
        $this->nick = $nick;
    }

    /**
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param string $province
     */
    public function setProvince($province)
    {
        $this->province = $province;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return int
     */
    public function getUin()
    {
        return $this->uin;
    }

    /**
     * @param int $uin
     */
    public function setUin($uin)
    {
        $this->uin = $uin;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @param string $card
     */
    public function setCard($card)
    {
        $this->card = $card;
    }

    /**
     * @return string
     */
    public function getIsVip()
    {
        return $this->isVip;
    }

    /**
     * @param string $isVip
     */
    public function setIsVip($isVip)
    {
        $this->isVip = $isVip;
    }

    /**
     * @return int
     */
    public function getVipLevel()
    {
        return $this->vipLevel;
    }

    /**
     * @param int $vipLevel
     */
    public function setVipLevel($vipLevel)
    {
        $this->vipLevel = $vipLevel;
    }

    /**
     * @param int $flag
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;
    }

    /**
     * @return int
     */
    public function getFlag()
    {
        return $this->flag;
    }
}