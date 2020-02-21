<?php
require_once ("config.php");
if (!empty($_SESSION['user_id'])){
    header("location: /guest_book/index.php");
}
$errors = [];
        if(!empty($_POST)){
            $errors = [];
            if(empty($_POST['user_name'])){
                $errors[]='Please enter User Name';
            }
            if (empty ($_POST['email'])){
                $errors[]='Please enter email';
            }
            if (empty ($_POST['first_name'])){
                $errors[]='Please enter First Name';
            }
            if (empty ($_POST['last_name'])){
                $errors[]='Please enter Last Name';
            }
            if (empty($_POST['password'])){
                $errors[]='Please enter password';
            }
            if (empty($_POST['confirm_password'])){
                $errors[]='Please enter confirm password';
            }
            if (strlen($_POST['user_name'])>100) {
                $errors[]='User Name is too. Max lenght is 100 characters';
            }
            if (strlen($_POST['first_name'])>80){
                $errors[]='User Name is too. Max lenght is 80 characters';
            }
            if (strlen($_POST['last_name'])>150){
                $errors[]='User Name is too. Max lenght is 150 characters';
            }
            if (strlen($_POST['password'])<6){
                $errors[]='Password should contains at least 6 characters';
            }
            if ($_POST['password']!==$_POST['confirm_password']){
                $errors[]='You confirm password is not match password!';
            }
       if (empty($errors)){
               $user = new User();
               $user->userName=$_POST['user_name'];
               $user->email=$_POST['email'];
               $user->password=sha1($_POST['password'].SALT);
               $user->firstName=$_POST['first_name'];
               $user->lastName=$_POST['last_name'];
               $user->save();

           }

     header("location: /guest_book/login.php?registration=1");//отображ в строке гет информацию на странице регистрации об успешной регистрации
           /* $stmt= $dbConn->prepare('INSERT INTO users(`username`,`email`,`password`,`first_name`,`last_name`)
             VALUES(:username, :email, :password, :first_name, :last_name)');
            $stmt->execute(array('username' => $_POST['user_name'],'email'=>$_POST['email'],'password'=> sha1($_POST['password'].SALT),
                                 'first_name' => $_POST['first_name'],'last_name' => $_POST['last_name']));
                header("location: /guest_book/login.php?registration=1");//отображ в строке гет информацию на странице регистрации об успешной регистрации
            */
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Guest Book</title>
        <meta charset="UTF-8">
    </head>
    <body>

    <h1>Registration Page</h1>
        <div>
            <form method="POST">
                <div style="color:red;">
                    <?php foreach ($errors as $error):?>
                    <p><?php echo $error;?></p>
                    <?php endforeach;?>
                </div>
                <div>
                    <label>User Name:</label>
                <div>
                    <input type="text" name="user_name" required ="" value ="<?php echo (!empty($POST['user_name']) ? $_POST['user_name'] : '');?>"/>
                </div>
                </div>
                <div>
                    <label>Email:</label>
                <div>
                    <input type="email" name="email" required ="" value ="<?php echo (!empty($POST['email']) ? $_POST['email'] : '');?>"/>
                </div>
                </div>
                <div>
                    <label>First Name:</label>
                <div>
                    <input type="text" name="first_name" required ="" value ="<?php echo (!empty($POST['first_name']) ? $_POST['first_name'] : '');?>"/>
                </div>
                </div>
                <div>
                <label>Last Name:</label>
                <div>
                    <input type="text" name="last_name" required ="" value ="<?php echo (!empty($POST['last_name']) ? $_POST['last_name'] : '');?>"/>
                </div>
                </div>
                <div>
                    <label> Password:</label>
                <div>
                    <input type="password" name="password" required ="" value =""/>
                </div>
                </div>
                <div>
                <label>Confirm Password:</label>
                    <div>
                    <input type="password" name="confirm_password" required ="" value =""/>
                </div>
                </div>
                <div>
                    <br/>
                    <input type="submit" name ="submit" value ="Register">
                </div>
            </form>
        </div>
    </body>
    </html>