<?php

class Model {

    private $pdo;
    private $sql;

    function __construct($credentials) {
        $dbHost = $credentials['dbHost'];
        $dbName = $credentials['dbName'];
        $dbUser = $credentials['dbUser'];
        $dbPassword = $credentials['dbPassword'];
        $this->pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);    
    }

    public function getPagesCount() {
    $this->sql = 'SELECT COUNT(id) AS items FROM news_table;';
    $result = $this->pdo->query($this->sql)->fetchColumn();
    return ceil($result/5);
    }

    public function getNews($page = 0) {
        // 5 NEWS WITH LINKS
        if ($page > 1) {
        $offset = ($page * 5) - 1;
        }
        else $offset = 0;

        $stmt = $this->pdo->prepare("SELECT * FROM news_table LIMIT 5 OFFSET :offset ;");
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function newText($title, $content, $id = 0) {
        if ($id > 0) {
            // UPDATE
            $stmt = $this->pdo->prepare("UPDATE news_table set Title = :title, Slug = :slug, Body = :content  where Id = :id");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':slug', $this->createSlug($content));
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
            $stmt->execute();
        } else {
            // INSERT
            $stmt = $this->pdo->prepare("INSERT INTO news_table (Title, Slug, Body) VALUES (:title, :slug, :content)");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':slug', $this->createSlug($content));
            $stmt->bindParam(':content', $content);
            $stmt->execute();
        }
    }

    public function getItem($id) {
        // GET A SEPARTE NEWS ITEM WITH COMMENTS
        $stmt = $this->pdo->prepare("SELECT * FROM news_table WHERE Id = :id ;");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getComments($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM comments WHERE News_id = :id ;");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addComment($id, $text) {
        $stmt = $this->pdo->prepare("INSERT INTO comments (News_id, Body) VALUES (:id, :content)");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':content', $text);
        $stmt->execute();
    }

    public function deleteComment($id) {
        $sql = "DELETE FROM comments WHERE Id =  :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);   
        $stmt->execute();
    }

    private function createSlug(string $text) {
        return substr($text,0,40).' ...';
    }

}