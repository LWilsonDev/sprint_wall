<?php include("header.php");
require_once ("includes/user.php"); ?>

<?php
$message="";
if(!$session->is_signed_in()){
    redirect('login.php');
}

//if(empty($_GET['id'])) {
//    redirect("users.php");
//}

$user = User::find_by_id($session->user_id);

if(isset($_POST['update'])) {
    if($user){
        $user->username = $_POST['username'];
        $user->first_name = $_POST['first_name'];
        $user->last_name = $_POST['last_name'];
        $user->password = $_POST['password'];

        if(empty($_FILES['user_image'])) {
            echo('no file');
            $user->save();

        } else {
            
            $user->set_file($_FILES['user_image']);
            
            $user->upload_photo();
            $user->save_user_and_image();

//            redirect("edit_user.php?id={$user->id}");
        }
    }
}



?>


<div class=" col-md-4 mx-auto mt-4">
    <h1>Profile</h1>
            <div class="user_image_box" style="background-image: url('<?php echo $user->upload_photo(); ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;" >
                 
            </div>


            <form action="" method="POST" enctype="multipart/form-data">

                <div class="">
                    <div class="form-group">
                        <label for="user_image">Profile Image</label>
                        <input class="form-control-file"  type="file" name="user_image">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" value="<?php echo $user->username; ?>">
                    </div>
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" class="form-control"  value="<?php echo $user->first_name; ?>">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" class="form-control"  value="<?php echo $user->last_name; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control"  value="<?php echo $user->password; ?>">
                    </div>
                    <div class="form-group">

                        <input type="submit" name="update" class="btn btn-primary pull-right" value="Update">
                        <a id="user-id" href="delete_user.php?id=<?php echo $user->id; ?>" name="delete" class="btn btn-danger pull-left" >Delete</a>
                    </div>

                </div>
            </form>
        </div>

    </div>
</div>
    <!-- /.row -->




<?php include("footer.php"); ?>

