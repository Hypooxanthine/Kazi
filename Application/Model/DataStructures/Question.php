<?php

class Token
{
    public int $idToken;
    public string $content;
    public int $idQuestion;
}

class Question
{
    public int $idQuestion;
    public ?string $imagePath = null;
    public int $badTokenIndex;
    public string $correctToken;
    public int $idCategory;
    public array $tokens;

    function __construct()
    {
        $this->tokens = array();
    }
}

?>