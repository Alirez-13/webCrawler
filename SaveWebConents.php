<?php
require_once "Database.php";

class SaveWebConents
{
    private static ?SaveWebConents $instance = null;

    public function saveToDb($URLPath, $wordCounter, $imgCounter, $specificWordCounter)
    {
        try {
            $database = Database::getInstance();
            $connection = $database->getConnection();
            $query = "INSERT INTO Links (URL_Path, Word_Counter, Specific_Words, Img_Number) VALUES (:URL_Path, :word_counter, :Specific_Word, :img_number)";
            $stmt = $connection->prepare($query);
            $stmt->bindParam(':URL_Path', $URLPath);
            $stmt->bindParam(':word_counter', $wordCounter);
            $stmt->bindParam(':Specific_Word', $specificWordCounter);
            $stmt->bindParam(':img_number', $imgCounter);

            if ($stmt->execute($query)) {
                return true;
            } else return false;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new SaveWebConents();
        }
        return self::$instance;
    }
}