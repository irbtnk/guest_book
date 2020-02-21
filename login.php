<?php
require_once ("config.php");
if (!empty($_SESSION['user_id'])){ //если у нас есть user_id в сессии то делаем редирект на страницу с комментариями
    header("location: /guest_book/index.php");
}
$errors = [];
$isRegistered = 0;
if(!empty($_GET['registration'])){
    $isRegistered = 1;
}
if (!empty($_POST)) {
    if (empty($_POST['user_name'])){
        $errors[]='Please enter User Name / Email';
    }
    if (empty($_POST['password'])){
        $errors[]='Please enter password';
    }
    if (empty($errors)) {
        $user = new User();
        $user = $user->checkLogin($_POST['user_name'], sha1($_POST['password'].SALT));
        if (!empty($user->id)){
            $_SESSION['user_id'] = $user->id;
            header("location: /guest_book/index.php");
            }else {
                $errors[] = 'Please enter valid credentails';
        }
                /* $stmt = $dbConn->prepare('SELECT id FROM users WHERE(username = :username or email = :username) and password = :password'); // проверяем на соответствие того, что введено в поле и того что в бд
                $stmt->execute(array('username' => $_POST['user_name'],'password' => sha1($_POST['password'].SALT))); // sha1 - получаем пароль введенный в форме из хеш
                $id = $stmt->fetchColumn();//єта фун-я достает значение столбца id который был в селекте
                if (!empty($id)) {
                    $_SESSION['user_id'] = $id;
                    die("ВЫ успешно авторизированны!");
                } else {
                    $errors[] = 'Please enter valid credentails';
                }*/
            }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Guest Book</title>
    <meta charset="UTF-8">
</head>
<body>
<?php if(!empty($isRegistered)) :?>
    <h2>Вы успешно зарегистрировались! Используйте свои данные для входа на сайт!</h2>
<?php endif;?>
<h1>Log In Page</h1>
<div>
    <form method="POST">
        <div style="color:red;"> <!-- блок для вывода ошибок валидации -->
            <?php foreach ($errors as $error):?> <!--перебираем массив ошибок-->
                <p><?php echo $error;?></p>
            <?php endforeach;?>
        </div>
        <div>
            <label>User Name / Email:</label>
            <div>
                <input type="text" name="user_name" required ="" value ="<?php echo (!empty($POST['user_name']) ? $_POST['user_name'] : '');?>"/>
            </div>
        </div>
        <div>
            <label> Password:</label>
            <div>
                <input type="password" name="password" required ="" value =""/>
        </div>
            <div>
                <br/>
                <input type="submit" name ="submit" value ="Log In">
            </div>
    </form>
</div>
</body>
</html>
