<?php
class DB{// помещаем свойства данного класса
    protected $conn = null;//хранится коннекшн к бд, мы не должны к нему обращаться с других файлов
    private $_host = HOST;
    private $_dbname = DBNAME;
    private $_user = USER;
    private $_password = PASSWORD;
    private $_error;// записываем какие-либо ошибки которые происходят к подкл к бд
    public function __construct(){//выполняется автоматически при создании обьекта класса дб. сюда пишем то что было в конфиге, подставляя сюда значения полей из класса ДБ
        $dsn = "mysql:host=".$this->_host.";dbname=".$this->_dbname.";charset=utf8";
        try{
            $this->conn = new PDO($dsn, $this->_user, $this->_password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $e){
            $this->conn=null;
            $this->_error= $e->getMessage();// записываем ошибку
        }
    }
    public function getError(){// вернет значение ошибки
        return $this->_error;
    }
}