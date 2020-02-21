<?php
require_once ("config.php");
if (empty ($_SESSION ['user_id'])){ // если юзер не залогинен, то мы будем перенаправлять на страницу авторизации
    header("location: /guest_book/login.php");
}
$comment = new Comment();
if(!empty($_POST['comment'])){
    $comment->comment = $_POST['comment'];// если в посте пришло не пустое поле коммен- это значит что мы должны добавить новый коммент в таблицу
    $comment->userId = $_SESSION['user_id'];
    $comment->save();// сохраняем коммент в бд

}
$comments = $comment->findAll();//вернет массив комментариев, ниже в форече мы будем перебирать этот массив
/*if(!empty($_POST['comment'])){//вставка комментов в бд
    $stmt=  $dbConn->prepare("INSERT INTO comments (`user_id`,`comment`) VALUES(:user_id,:comment)");
    $stmt->execute(array('user_id' => $_SESSION['user_id'],'comment' => $_POST['comment']));
}
$stmt =  $dbConn->prepare("SELECT * FROM comments ORDER BY id DESC");// сортировка комментов по убыванию, чтоб выводились самые свежие
$stmt->execute();
$comments = $stmt->fetchAll();//будут содержаться все комменты  что есть в бд*/

?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title> Comments Page</title>
    <style>
        #comments-header{text-align: center;}
        #comments-form{border: 1px dotted black; width: 50%; padding-left: 20px;}
        #comments-form textarea{ width: 70%; min-height: 100px;}
        #comments-panel { border: 1px dashed black; width 50%; padding-left: 20px; margin-top: 20px;}
        .comment-date{font-style: italic}
    </style>
</head>
<body>
<div id="comments-header">
    <h1>Comments Page</h1>
</div>
<div id="comments-form">
    <h3>Please add your comment</h3>
    <form method="POST">
        <div>
            <label>Comment </label>
            <div>
                <textarea name="comment"></textarea>
            </div>
        </div>
        <div>
            <br>
            <input type="submit" name="submit" value="Save">
        </div>
    </form>
</div>
<div id="comments-panel">
    <h3>Comments:</h3>
    <?php foreach ($comments as $comment): ?><!-- перебираем массив комментов -->
    <p <?php if($comment['user_id']==$_SESSION['user_id']) // выделяем комменты авторизированного пользователя жирным
        echo 'style="font-weight: bold;"';?>>
        <?php echo $comment['comment'];?>
        <span class="comment-date">
        (<?php echo $comment['created_at'];?>)</span></p> <!-- выводим время создавшегося коммента-->
    <?php endforeach;?>
</div>

</body>
</html>

