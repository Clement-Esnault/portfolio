<?php

class Chapter
{
    private $id;
    private $title;
    private $description;
    private $choices;
    private $image;

    public function __construct($id, $title, $description, $choices, $image = null) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->choices = $choices;
        $this->image = $image;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getChoices() {
        return $this->choices;
    }

    public function getImage() {
        return $this->image;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setChoices($choices) {
        $this->choices = $choices;
    }

    public function setImage($image) {
        $this->image = $image;
    }
}

?>
