
<?php require_once("header.php"); ?>

<?php

if($session->is_signed_in()) {
    redirect("index.php");
}

if(isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $password = trim($_POST['password']);

    //method to check  db user
    $user_found = User::verify_user($username, $password);

    if($user_found) {
        $the_message = 'username already exists. Please login';
//        redirect("login.php");
    } else {
        //create new user

        $user = new User();
        $user->username = $username;
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->password = $password;

        $user->create();

        $the_message = 'User added';
        redirect('index.php');

    }

} else {
    $the_message="";
    $username = "";
    $first_name = "";
    $last_name = "";
    $password = "";
}

?>


<div class=" col-md-4 mx-auto mt-4">
<h1>Register</h1>
<?php if($the_message || $the_message !== ''){ ?>
    <div class="alert alert-warning" role="alert">
        <?php echo $the_message; ?> <a href="login.php">here</a>
    </div>
    <?php } ?>

    <form id="login-id" action="" method="post">

        <div class="form-group">
            <label for="username">Username</label>
            <input required type="text" class="form-control" name="username" value="<?php echo htmlentities($username); ?>" >

        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input required type="password" class="form-control" name="password" value="<?php echo htmlentities($password); ?>">

        </div>

        <div class="form-group">
            <label for="first_name">First name</label>
            <input required type="text" class="form-control" name="first_name" value="<?php echo htmlentities($first_name); ?>" >

        </div>

        <div class="form-group">
            <label for="last name">Last name</label>
            <input required type="text" class="form-control" name="last_name" value="<?php echo htmlentities($last_name); ?>" >

        </div>


        <div class="form-group">
            <input type="submit" name="submit" value="Submit" class="btn btn-primary">

        </div>


    </form>


</div>
