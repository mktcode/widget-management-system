<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

/**
 * Class Page
 * @package App\Entity
 *
 * @Entity()
 * @Table(name="content_category")
 */
class ContentCategory
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
    protected $name;

    /**
     * @var ArrayCollection
     * @OneToMany(targetEntity="App\Entity\Content", mappedBy="contentCategory")
     */
    protected $contents;

    /**
     * @OneToMany(targetEntity="App\Entity\ContentCategory", mappedBy="parent")
     */
    protected $children;

    /**
     * @ManyToOne(targetEntity="App\Entity\ContentCategory", inversedBy="children")
     * @JoinColumn(name="parent", referencedColumnName="id")
     */
    protected $parent;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->contents = new ArrayCollection();
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Content
     */
    public function getContent()
    {
        return $this->contents;
    }

    /**
     * @param Content $content
     */
    public function addContent(Content $content) {
        $this->contents[] = $content;
        $content->setContentCategory($this);
    }

    /**
     * @return mixed
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * @param ContentCategory $parent
     */
    public function setParent(ContentCategory $parent) {
        $this->parent = $parent;
    }

    /**
     * @return mixed
     */
    public function getChildren() {
        return $this->children;
    }

    /**
     * @param ContentCategory $child
     */
    public function addChild(ContentCategory $child) {
        $this->children[] = $child;
        $child->setParent($this);
    }
}