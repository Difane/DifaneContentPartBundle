<?php

namespace Difane\Bundle\ContentPartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Difane\Bundle\ContentPartBundle\Entity\ContentPart
 *
 * @ORM\Table(name="difane_contentpart")
 * @ORM\Entity(repositoryClass="Difane\Bundle\ContentPartBundle\Entity\ContentPartRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity("name")
 */
class ContentPart
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string $rawContent
     *
     * @ORM\Column(name="rawContent", type="text")
     */
    private $rawContent;

    /**
     * @var string $contentFormatter
     *
     * @ORM\Column(name="contentFormatter", type="string", length=255)
     */
    private $contentFormatter;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var \Sonata\FormatterBundle\Formatter\Pool $formatterPool
     */
    private $formatterPool;

    public function __construct($name="", $title="", $formatter="", $rawContent="")
    {
        $this->name = $name;
        $this->title = $title;
        $this->contentFormatter = $formatter;
        $this->rawContent = $rawContent;
    }

    /**
     * @ORM\PrePersist
     */
    public function handlePrePersist()
    {
        if(is_null($this->title))
        {
            $this->title = "";
        }

        if(is_null($this->rawContent))
        {
            $this->rawContent = "";
        }
    }

    /**
     * Returns ContentPart string representation
     */
    public function __toString()
    {
        return $this->getName();
    }

    public function setFormatterPool(\Sonata\FormatterBundle\Formatter\Pool $formatterPool)
    {
        $this->formatterPool = $formatterPool;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        if(is_null($this->contentFormatter))
        {
            throw new \RuntimeException("ContentPart instance must have contentFormatter be set for getting transformed content");
        }

        if(is_null($this->formatterPool))
        {
            throw new \RuntimeException("ContentPart instance must have formatterPool be set for getting transformed content");
        }

        return $this->formatterPool->transform($this->contentFormatter, $this->rawContent);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return ContentPart
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set rawContent
     *
     * @param string $rawContent
     * @return ContentPart
     */
    public function setRawContent($rawContent)
    {
        $this->rawContent = $rawContent;
    
        return $this;
    }

    /**
     * Get rawContent
     *
     * @return string
     */
    public function getRawContent()
    {
        return $this->rawContent;
    }

    /**
     * Set contentFormatter
     *
     * @param string $contentFormatter
     * @return ContentPart
     */
    public function setContentFormatter($contentFormatter)
    {
        $this->contentFormatter = $contentFormatter;
    
        return $this;
    }

    /**
     * Get contentFormatter
     *
     * @return string
     */
    public function getContentFormatter()
    {
        return $this->contentFormatter;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ContentPart
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
}
