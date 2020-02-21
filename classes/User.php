<?php
class User extends DB
{
    public $id;
    public $userName;
    public $email;
    public $firstName;
    public $lastName;
    public $password;

    public function save()// добавляет юзеров в бд при регистрации
    {
            $stmt = $this->conn->prepare('INSERT INTO users (`username`,`email`,`password`,`first_name`,`last_name`, `created_at`) VALUES(:user_name, :email, :password, :first_name, :last_name, :created_at)');
            $stmt->execute(array(':user_name' => $this->userName, ':email' => $this->email, ':password' => $this->password, ':first_name' => $this->firstName, ':last_name' => $this->lastName, ':created_at' => date('Y-m-d H:i:s')));
                $this->id = $this->conn->lastInsertId();// возвращает id последней вставленной записи в таблицу
        return $this->id;
    }
    public function find($id)//поиск значения по id
    {
        $stmt = $this->conn->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute(array('id' => $id));
        $user = $stmt->fetch(PDO::FETCH_LAZY);//позволяет из массива который возвращает fetch получать свойства через значения ассоциативного массива и  через поле класса
        if (!empty($user)) {//получаем значения $user и затем вытягиваем по имени полей значения из нашей таблицы Юзер
            $this->id = $id;
            $this->userName = $user->user_name;
            $this->email = $user->email;
            $this->firstName = $user->first_name;
            $this->lastName = $user->last_name;
            return $this;// возвращаем обьект данного класса с фун-ей  find
        }
    }

    public function checkLogin($userName, $password)//проверка логина и пароля
    {
        $stmt = $this->conn->prepare('SELECT id FROM users WHERE(username = :username or email = :username) and password = :password');
        $stmt->execute(array('username'=>$userName, 'password' =>$password));
        $user = $stmt->fetch(PDO::FETCH_LAZY);
        if(!empty($user)){
            $this->id = $user->id;
            $this->userName= $user->user_name;
            $this->email=$user->email;
            $this->firstName=$user->first_name;
            $this->lastName=$user->last_name;
            return $this;
        }else{
            return false;
        }
    }
}