<?php

require_once '../Model/QuestionModel.php';

$newQuestion = new Question();
$newQuestion->idCategory = QuestionModel::GetCategoryIdFromName('Histoire');
$newQuestion->badTokenIndex = 0;
$newQuestion->correctToken = 'Bonsoir,';
$t = new Token();
$t->content = "Bonjour,";
array_push($newQuestion->tokens, $t);
$t = new Token();
$t->content = "je";
array_push($newQuestion->tokens, $t);
$t = new Token();
$t->content = "suis";
array_push($newQuestion->tokens, $t);
$t = new Token();
$t->content = "une";
array_push($newQuestion->tokens, $t);
$t = new Token();
$t->content = "question";
array_push($newQuestion->tokens, $t);
$t = new Token();
$t->content = "d'histoire.";
array_push($newQuestion->tokens, $t);

//QuestionModel::AddQuestion($newQuestion);
//QuestionModel::RemoveQuestionById(10);

$questions = QuestionModel::GetRandomQuestionsByCategoryId(1, QuestionModel::GetCategoryIdFromName('Histoire'));

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