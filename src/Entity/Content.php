<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

/**
 * Class Page
 * @package App\Entity
 *
 * @Entity()
 * @Table(name="content")
 */
class Content
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id = null;

    /**
     * @var string
     * @Column(type="text", length=100)
     */
    protected $title;

    /**
     * @var string
     * @Column(type="text")
     */
    protected $type;

    /**
     * @var string
     * @Column(type="text", length=32)
     */
    protected $hash;

    /**
     * @var ArrayCollection
     * @OneToMany(targetEntity="App\Entity\ContentData", mappedBy="content")
     */
    protected $contentData;

    /**
     * @var Content
     * @ManyToOne(targetEntity="App\Entity\ContentCategory", inversedBy="contents")
     */
    protected $contentCategory;

    /**
     * @var bool
     * @Column(type="boolean")
     */
    protected $active;

    public function __construct()
    {
        $this->contentData = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     * @return $this
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getContentData()
    {
        return $this->contentData;
    }

    /**
     * @param ContentData $contentData
     */
    public function addContentData($contentData)
    {
        $this->contentData[] = $contentData;
        $contentData->setContent($this);
    }

    /**
     * @return ContentCategory
     */
    public function getContentCategory()
    {
        return $this->contentCategory;
    }

    /**
     * @param ContentCategory $contentCategory
     * @return $this
     */
    public function setContentCategory($contentCategory)
    {
        $this->contentCategory = $contentCategory;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }
}