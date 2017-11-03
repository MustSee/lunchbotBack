<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Place_to_eat
 *
 * @ORM\Table(name="place_to_eat")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Place_to_eatRepository")
 */
class Place_to_eat
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
     * @var string
     *
     * @ORM\Column(name="town", type="string", length=255, nullable=true)
     */
    private $town;

    /**
     * @var string
     *
     * @ORM\Column(name="picture_path", type="string", length=255, nullable=true)
     */
    private $picturePath;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var float
     *
     * @ORM\Column(name="coords_latitude", type="float", nullable=true)
     */
    private $coordsLatitude;

    /**
     * @var float
     *
     * @ORM\Column(name="coords_longitude", type="float", nullable=true)
     */
    private $coordsLongitude;


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
     * @return Place_to_eat
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
     * @return Place_to_eat
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
     * Set town
     *
     * @param string $town
     *
     * @return Place_to_eat
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get town
     *
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set picturePath
     *
     * @param string $picturePath
     *
     * @return Place_to_eat
     */
    public function setPicturePath($picturePath)
    {
        $this->picturePath = $picturePath;

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
     * @return Place_to_eat
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
     * Set coordsLatitude
     *
     * @param float $coordsLatitude
     *
     * @return Place_to_eat
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
     * @return Place_to_eat
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
}

