<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Place
 *
 * @ORM\Table(name="place")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlaceRepository")
 */
class Place
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255, nullable=true)
     */
    private $adress;

    /**
     * @var float
     *
     * @ORM\Column(name="coordsLatitude", type="float", nullable=true)
     */
    private $coordsLatitude;

    /**
     * @var float
     *
     * @ORM\Column(name="coordsLongitude", type="float", nullable=true)
     */
    private $coordsLongitude;

    /**
     * @var string
     *
     * @ORM\Column(name="picturePath", type="string", length=255, nullable=true)
     */
    private $picturePath;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var int
     *
     * @ORM\Column(name="likeSpot", type="integer")
     */
    private $likeSpot;

    public function __construct() {
        $this->setLikeSpot(0);
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Place
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set adress
     *
     * @param string $adress
     *
     * @return Place
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set coordsLatitude
     *
     * @param float $coordsLatitude
     *
     * @return Place
     */
    public function setCoordsLatitude($coordsLatitude)
    {
        $this->coordsLatitude = $coordsLatitude;

        return $this;
    }

    /**
     * Get coordsLatitude
     *
     * @return float
     */
    public function getCoordsLatitude()
    {
        return $this->coordsLatitude;
    }

    /**
     * Set coordsLongitude
     *
     * @param float $coordsLongitude
     *
     * @return Place
     */
    public function setCoordsLongitude($coordsLongitude)
    {
        $this->coordsLongitude = $coordsLongitude;

        return $this;
    }

    /**
     * Get coordsLongitude
     *
     * @return float
     */
    public function getCoordsLongitude()
    {
        return $this->coordsLongitude;
    }

    protected function getUploadDir()
    {
        return 'images/';
    }

    /**
     * Set picturePath
     *
     * @param string $picturePath
     *
     * @return Place
     */
    public function setPicturePath($picturePath)
    {
        $this->picturePath = $this->getUploadDir().$picturePath;

        return $this;
    }

    /**
     * Get picturePath
     *
     * @return string
     */
    public function getPicturePath()
    {
        return $this->picturePath;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Place
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set likeSpot
     *
     * @param integer $likeSpot
     *
     * @return Place
     */
    public function setLikeSpot($likeSpot)
    {
        $this->likeSpot = $likeSpot;

        return $this;
    }

    /**
     * Get likeSpot
     *
     * @return int
     */
    public function getLikeSpot()
    {
        return $this->likeSpot;
    }
}

