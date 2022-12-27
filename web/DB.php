<?php

class db
{

    private $db;

    /**
     * Подключение к БД
     */
    public function __construct()
    {
        $this->db = new PDO('mysql:host=10.100.3.80;dbname=20269_blog', '20269', 'xiiiiq');
    }


    //Запрос на вывод всех постов

    public function getPosts(): array
    {
        return ($this->db->query('SELECT * FROM post INNER JOIN users ON post.id_user=users.id'))->fetchAll();
    }



    //Запрос на вывод постов по id поста

    public function getPostON($post)
    {
        return ($this->db->query('SELECT * FROM post JOIN users ON post.id_user=users.id WHERE id_post = '.$post))->fetchAll(PDO::FETCH_CLASS);
    }


    //Добавление статьи

    public function deletePost(int $id_post): bool
    {
        return ($this->db->prepare("DELETE FROM post WHERE id_post = ?"))->execute([$id_post]);
    }
 //Удвление статьи
    public function createPost(string $name, string $id_user, string $description, string $picture): bool
    {
        $result = $this->db->prepare("INSERT INTO post (name, id_user, description, picture) VALUES (:name, :id_user, :description, :picture)");
        return $result->execute([
            ':name' => $name,
            ':id_user' => $id_user,
            ':description' => $description,
            ':picture' => $picture
        ]);
    }

}
?>