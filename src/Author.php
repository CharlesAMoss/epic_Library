<?php

class Author
{

    private $author_name;
    private $id;

    function __construct($author_name, $id=NULL)
    {
        $this->author_name = $author_name;
        $this->id = $id;
    }

    function getAuthorName()
    {
        return $this->author_name;
    }

    function setAuthorName($new_author_name)
    {
        $this->author_name = $new_author_name;
    }

    function getId()
    {
        return $this->id;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO authors_t (author_name) VALUES ('{$this->getAuthorName()}')");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function find($search_id)
{
    $found_author = "";
    $authors = Author::getAll();
    foreach($authors as $author) {
        $author_id = $author->getId();
        if ($author_id == $search_id) {
            $found_author = $author;
        }
    }
    return $found_author;
}

    static function getAll()
    {
        $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors_t;");
        $authors = array();
        foreach($returned_authors as $author) {
            $author_name = $author['author_name'];
            $id = $author['id'];
            $new_author = new Author($author_name, $id);
            array_push($authors, $new_author);
        }

        return $authors;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM authors_t;");
    }

}

 ?>
