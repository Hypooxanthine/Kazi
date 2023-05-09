<?php

require_once '../Model/QuestionModel.php';

$questions = QuestionModel::GetRandomQuestionsByCategoryId(1, QuestionModel::GetCategoryIdFromName('Sciences'));

foreach($questions as $q)
{
    echo "<h1>Question id:$q->idQuestion</h1>";
    echo '<p>';
    echo "<p>Erreur à l'index $q->badTokenIndex</p>";

    $premier = true;

    foreach($q->tokens as $index => $token)
    {
        if($premier == true)
            $premier = false;
        else
            echo ' ';
        if($index == $q->badTokenIndex)
            echo "<span style='color:red'>";
        echo "$token->content";
        if($index == $q->badTokenIndex)
            echo '</span>';
    }

    echo '</p>';
    echo "<p>Token correct : '$q->correctToken'.</p>";
}

?>