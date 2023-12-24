<?php

/**
 * This class acts as a placeholder for an article.
 */
class Article
{
    /** @var int $id stores an ID of the article */
    private $id;

    /** @var string $title stores a title of the article */
    private $title;

    /** @var string $content stores content of the article */
    private $content;

    /** @var string $date stores publication date of the article */
    private $date;

    /**
     * Set the id of the article
     * 
     * @param int $id ID to be set
     * 
     * @return void
     */
    public function setID($id)
    {
        $this->id = $id;
    }

    /**
     * Get the id of the article
     * 
     * @return int ID of the article
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     * Set the title of the article
     * 
     * @param int $title ID to be set
     * 
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get the title of the article
     * 
     * @return int Title of the article
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the content of the article
     * 
     * @param int $content Content to be set
     * 
     * @return void
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get the content of the article
     * 
     * @return int Content of the article
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the publication date of the article
     * 
     * @param string $date Date to be set
     * 
     * @return void
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get the publication date of the article
     * 
     * @return string Publication date of the article
     */
    public function getDate()
    {
        return $this->date;
    }
}
