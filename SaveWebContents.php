<?php
require_once "Database.php";

class SaveWebContents
{
    private static ?SaveWebContents $instance = null;

    public function saveToDb($URLPath, $wordCounter, $imgCounter, $specificWordCounter)
    {
        try {
            $database = Database::getInstance();
            $connection = $database->getConnection();
            $query = "INSERT INTO Links (URL_Path, Word_Counter, Specific_Words, Img_Number) 
                        VALUES (:URL_Path, :word_counter, :Specific_Word, :img_number)";
            $stmt = $connection->prepare($query);
            $stmt->bindParam(':URL_Path', $URLPath);
            $stmt->bindParam(':word_counter', $wordCounter);
            $stmt->bindParam(':Specific_Word', $specificWordCounter);
            $stmt->bindParam(':img_number', $imgCounter);

            if ($stmt->execute($query)) {
                return true;
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    public function savePageContent($URLPath, $Plain_Text): bool
    {
        try {
            $database = Database::getInstance();
            $connection = $database->getConnection();
            $query = "INSERT INTO Pages (URL_Path, Plain_Text) VALUES (:URL_Path, :Plain_Text)";
            $stmt = $connection->prepare($query);
            $stmt->bindParam(':URL_Path', $URLPath);
            $stmt->bindParam(':Plain_Text', $Plain_Text);

            if ($stmt->execute()) {
                return true;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    public function searchPageContent(string $searchTerm): array
    {
        $result = array();
        try {
            $database = Database::getInstance();
            $connection = $database->getConnection();
            //Plain_Text LIKE :searchTerm
//            $query = "SELECT URL_Path FROM pages WHERE :searchTerm";
            $query = "SELECT URL_Path,
       (MATCH(Plain_Text) AGAINST (:searchTerm IN NATURAL LANGUAGE MODE)) AS relevance
    FROM Pages
    WHERE MATCH(Plain_Text) AGAINST (:searchTerm IN NATURAL LANGUAGE MODE)
    ORDER BY relevance DESC";

            $stmt = $connection->prepare($query);
            $stmt->bindParam(':searchTerm', $searchTerm);
            if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $result;
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new SaveWebContents();
        }
        return self::$instance;
    }
}