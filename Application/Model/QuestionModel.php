<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/DataStructures/Question.php';

class QuestionModel
{
    public static function GetTokensByQuestionId(int $idQuestion) : array
    {
        $db = Database::CreateDatabaseConnexion();
        $out = array();

        $statement = $db->prepare('SELECT * FROM token WHERE idQuestion = :i ORDER BY tokenIndex');
        $statement->execute
        (
            ['i' => $idQuestion]
        );

        $rawTokens = $statement->fetchAll();

        foreach($rawTokens as $rawToken)
        {
            array_push($out, QuestionModel::GetTokenFromRaw($rawToken));
        }

        return $out;
    }

    public static function GetRandomQuestionsByCategoryId(int $nb, int $category) : array
    {
        $db = Database::CreateDatabaseConnexion();

        //$statement = $db->prepare('SELECT * FROM question AS t1 JOIN (SELECT idQuestion FROM question ORDER BY RAND() LIMIT :l) as t2 ON t1.idQuestion=t2.idQuestion');
        $statement = $db->prepare("SELECT * FROM question
        WHERE idCategory = :c
        ORDER BY RAND()
        LIMIT $nb");
        $statement->execute
        (
            ['c' => $category]
        );

        $rawQuestions = $statement->fetchAll();

        $out = array();

        foreach($rawQuestions as $rawQuestion)
        {
            array_push($out, QuestionModel::GetQuestionFromRaw($rawQuestion));
        }

        return $out;
    }

    public static function GetCategoryIdFromName(string $name) : int
    {
        $db = Database::CreateDatabaseConnexion();

        $statement = $db->prepare("SELECT idCategory FROM category WHERE name = :n");
        $statement->execute
        (
            ['n' => $name]
        );

        $rawCategory = $statement->fetchAll();
        return $rawCategory[0]['idCategory'];
    }

    public static function GetCategoryNameFromId(int $id) : string
    {
        $db = Database::CreateDatabaseConnexion();

        $statement = $db->prepare("SELECT name FROM category WHERE idCategory = :i");
        $statement->execute
        (
            ['i' => $id]
        );

        $rawCategory = $statement->fetchAll();
        return $rawCategory[0]['name'];
    }

    public static function AddQuestion(Question $question) : void
    {
        $db = Database::CreateDatabaseConnexion();

        $statement = $db->prepare("INSERT INTO question (nbTokens, imagePath, badTokenIndex, correctToken, idCategory) VALUES (:n, :ip, :b, :c, :ic)");
        $statement->execute
        ([
            'n' => count($question->tokens),
            'ip' => ($question->imagePath == null ? '' : $question->imagePath),
            'b' => $question->badTokenIndex,
            'c' => $question->correctToken,
            'ic' => $question->idCategory
        ]);

        int: $insertedQuestionID = $db->lastInsertId();

        foreach($question->tokens as $index => $token)
        {
            QuestionModel::AddToken($token->content, $index, $insertedQuestionID);
        }
    }

    public static function AddCategory(string $name)
    {
        $db = Database::CreateDatabaseConnexion();

        $statement = $db->prepare("INSERT INTO category (name) VALUES (:n)");
        $statement->execute
        ([
            'n' => $name
        ]);
    }

    public static function RemoveQuestionById(int $id)
    {
        $db = Database::CreateDatabaseConnexion();

        $statement = $db->prepare("DELETE FROM question WHERE idQuestion = :i");
        $statement->execute
        ([
            'i' => $id
        ]);

        $statement = $db->prepare("DELETE FROM token WHERE idQuestion = :i");
        $statement->execute
        ([
            'i' => $id
        ]);
    }

    public static function RemoveCategoryById(int $id)
    {
        $db = Database::CreateDatabaseConnexion();

        $statement = $db->prepare("DELETE FROM category WHERE idCategory = :i");
        $statement->execute
        ([
            'i' => $id
        ]);
    }

    /* Private stuff */
    
    private static function GetTokenFromRaw(array $raw) : Token
    {
        $token = new Token();
        $token->idToken = $raw['idToken'];
        $token->idQuestion = $raw['idQuestion'];
        $token->content = $raw['content'];

        return $token;
    }

    private static function GetQuestionFromRaw(array $raw) : Question
    {
        $out = new Question();

        $out->idQuestion = $raw['idQuestion'];
        $out->idCategory = $raw['idCategory'];
        $out->imagePath = $raw['imagePath'];
        $out->badTokenIndex = $raw['badTokenIndex'];
        $out->correctToken = $raw['correctToken'];
        $out->tokens = QuestionModel::GetTokensByQuestionId($out->idQuestion);

        return $out;
    }

    private static function AddToken(string $content, int $index, int $idQuestion) : void
    {
        $db = Database::CreateDatabaseConnexion();

        $statement = $db->prepare("INSERT INTO token (content, tokenIndex, idQuestion) VALUES (:c, :t, :i)");
        $statement->execute
        ([
            'c' => $content,
            't' => $index,
            'i' => $idQuestion
        ]);
    }
}

?>