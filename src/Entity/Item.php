<?php

namespace App\Entity;

use App\Constant\ReputationBadge;
use App\Validator\Constraints\ItemName;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 * @ORM\Table(name="item")
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\Expose()
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose()
     * @ItemName()
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\Expose()
     * @Assert\Type("int")
     * @Assert\Range(
     *      min = 0,
     *      max = 5
     * )
     */
    private $rating;

    /**
     * @ORM\Column(type="string")
     * @Assert\Regex("/^(hotel|alternative|hostel|lodge|resort|guest-houses)$/")
     * @Serializer\Expose()
     */
    private $category;

    /**
     * @ORM\Column(type="text")
     * @Serializer\Expose()
     * @Assert\Url()
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\Expose()
     * @Assert\Type("int")
     * @Assert\Range(
     *      min = 0,
     *      max = 1000
     * )
     */
    private $reputation;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\Expose()
     * @Assert\Type("int")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\Expose()
     * @Assert\Type("int")
     */
    private $availability;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="items")
     * @Serializer\Expose()
     * @Assert\NotBlank()
     */
    private $location;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     *
     * @return Item
     */
    public function setId(int $id): Item
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Item
     */
    public function setName($name): Item
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return integer
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param integer $rating
     *
     * @return Item
     */
    public function setRating(int $rating): Item
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $category
     *
     * @return Item
     */
    public function setCategory(string $category): Item
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     *
     * @return Item
     */
    public function setImage(string $image): Item
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return integer
     */
    public function getReputation()
    {
        return $this->reputation;
    }

    /**
     * @param integer $reputation
     *
     * @return Item
     */
    public function setReputation(int $reputation): Item
    {
        $this->reputation = $reputation;

        return $this;
    }

    /**
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param integer $price
     *
     * @return Item
     */
    public function setPrice(int $price): Item
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return integer
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * @param integer $availability
     *
     * @return Item
     */
    public function setAvailability(int $availability): Item
    {
        $this->availability = $availability;

        return $this;
    }

    /**
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param Location $location
     *
     * @return Item
     */
    public function setLocation(Location $location): Item
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return string
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName("reputationBadge")
     */
    public function getReputationBadge(): string
    {
        if ($this->getReputation() <= 500) {
            return ReputationBadge::RED;
        } elseif ($this->getReputation() <= 799) {
            return ReputationBadge::YELLOW;
        } else {
            return ReputationBadge::GREEN;
        }
    }
}
