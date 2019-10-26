<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 * @ORM\Table(name="location")
 */
class Location
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\Expose()
     * @Assert\NotBlank()
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose()
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose()
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose()
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $country;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\Expose()
     * @Assert\NotBlank()
     * @Assert\Type("int")
     * @Assert\Length(5)
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose()
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Item", mappedBy="location")
     * @Serializer\Exclude()
     */
    private $items = [];

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     *
     * @return Location
     */
    public function setId(int $id): Location
    {
        $this->id = $id;

        return $this;
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
     *
     * @return Location
     */
    public function setCity(string $city): Location
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     *
     * @return Location
     */
    public function setState(string $state): Location
    {
        $this->state = $state;

        return $this;
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
     *
     * @return Location
     */
    public function setCountry(string $country): Location
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return integer
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param integer $zipCode
     *
     * @return Location
     */
    public function setZipCode(int $zipCode): Location
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     *
     * @return Location
     */
    public function setAddress(string $address): Location
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param Item $item
     *
     * @return Location
     */
    public function addItem(Item $item): Location
    {
        $this->items []= $item;

        return $this;
    }
}
