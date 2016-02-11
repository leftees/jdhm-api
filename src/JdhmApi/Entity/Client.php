<?php

namespace JdhmApi\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="JdhmApi\Repository\ClientRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Client
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Expose
     * @JMS\Since("1.0")
     * @JMS\SerializedName("id")
     * @JMS\Groups({"site"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     *
     * @JMS\Expose
     * @JMS\Since("1.0")
     * @JMS\SerializedName("firstName")
     * @JMS\Groups({"site"})
     *
     * @Assert\Length(
     *      min = "2",
     *      max = "150",
     *      minMessage = "First Name must be at least {{ limit }} long",
     *      maxMessage = "First Name can't be longer than {{ limit }}"
     * )
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     *
     * @JMS\Expose
     * @JMS\Since("1.0")
     * @JMS\SerializedName("lastName")
     * @JMS\Groups({"site"})
     *
     * @Assert\Length(
     *      min = "2",
     *      max = "150",
     *      minMessage = "Last Name must be at least {{ limit }} long",
     *      maxMessage = "Last Name can't be longer than {{ limit }}"
     * )
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     *
     * @JMS\Expose
     * @JMS\Since("1.0")
     * @JMS\SerializedName("email")
     * @JMS\Groups({"site"})
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOfBirth", type="datetime", nullable=true)
     *
     * @JMS\Expose
     * @JMS\Since("1.0")
     * @JMS\SerializedName("dateOfBirth")
     * @JMS\Groups({"site"})
     */
    private $dateOfBirth;


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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Client
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Client
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Client
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     *
     * @return Client
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }
}
