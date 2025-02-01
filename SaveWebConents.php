<?php
require_once "Database.php";

class SaveWebConents
{
    private string $URLPath;
    private int $wordCounter;
    private int $imgCounter;
    private string $specificWordCounter;

    public function __construct($URLPath, $wordCounter, $imgCounter, $specificWordCounter)
    {
        $this->URLPath = $URLPath;
        $this->wordCounter = $wordCounter;
        $this->imgCounter = $imgCounter;
        $this->specificWordCounter = $specificWordCounter;
    }

    public function saveToDb()
    {
        try {
            $database = Database::getInstance();
            $connection = $database->getConnection();
            $query = "INSERT INTO Links (URL_Path, Word_Counter, Specific_Words, Img_Number) VALUES (:URL_Path, :word_counter, :Specific_Word, :img_number)";
            $stmt = $connection->prepare($query);
            $stmt->bindParam(':URL_Path', $this->URLPath);
            $stmt->bindParam(':word_counter', $this->wordCounter);
            $stmt->bindParam(':Specific_Word', $this->specificWordCounter);
            $stmt->bindParam(':img_number', $this->imgCounter);

            if ($stmt->execute($query)) {
                return true;
            } else return false;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }


}