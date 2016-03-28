<?php

namespace App\Entity;


use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

/**
 * Class Page
 * @package App\Entity
 *
 * @Entity()
 * @Table(name="content_data")
 */
class ContentData
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id = null;

    /**
     * @var string
     * @Column(type="text")
     */
    protected $dataKey;

    /**
     * @var string
     * @Column(type="text")
     */
    protected $dataValue;

    /**
     * @var Content
     * @ManyToOne(targetEntity="App\Entity\Content", inversedBy="contentData")
     */
    protected $content;

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
    public function getDataKey()
    {
        return $this->dataKey;
    }

    /**
     * @param string $dataKey
     * @return $this
     */
    public function setDataKey($dataKey)
    {
        $this->dataKey = $dataKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getDataValue()
    {
        return $this->dataValue;
    }

    /**
     * @param string $dataValue
     * @return $this
     */
    public function setDataValue($dataValue)
    {
        $this->dataValue = $dataValue;

        return $this;
    }

    /**
     * @return Content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param Content $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }
}