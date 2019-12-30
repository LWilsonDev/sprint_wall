<?php include("header.php");
require_once ("includes/user.php");
require_once("includes/post.php");
require_once("includes/sprint.php");
// include("post_modal.php");
 ?>

<?php

if(!$session->is_signed_in()){
    redirect('login.php');
}


$sprint_id = $_SESSION['sprint_id'];
if(!$sprint_id){
    redirect('index.php');
}


if(isset($_POST['submit'])) {
    $title = trim($_POST['title']);
    $extra_text = trim($_POST['extra_text']);
    $category = trim($_POST['category']);
    $sprint_id = trim($_POST['sprint_id']);
echo('HHHHHHHH');
    $post = new Post();
        $post->title = $title;
        $post->extra_text = $extra_text;
        $post->category = $category;
        $post->sprint_id = $_SESSION['sprint_id'];
        $post->author_id = $_SESSION['user_id'];

        $post->save();

        $msg = 'Post added';
        redirect('board.php');
} else {
    $msg="";
}

$user = User::find_by_id($session->user_id);
$posts = Post::find_the_posts($sprint_id);
$sprint = Sprint::find_by_id($sprint_id);





?>


<div class='col-sm-12'>
    <h1 class='inline'>Board <small><?php echo ($sprint->title); ?></small></h1>
    <hr>
</div>

<?php if($msg || $msg !== ''){ ?>
        <div class="alert alert-warning" role="alert">
            <?php echo $msg; ?>
        </div>
    <?php } ?>


<div class='col-sm-12'>
    <h2 class='inline mr-2'>Start </h2>
    <button onclick="selectCategory('start_select')"  type='button' data-toggle="modal" data-target="#postModal" class='btn btn-info pull-right'>Add Post</button>

<div class='row mt-4'>
    <?php foreach($posts as $post): ?>

        <?php if($post->category == 'Start') : ?>

             <?php $target = '#'.$post->id . 'target'; ?>


            <div class="col-md-4 col-lg-3" >
                <div class='card mb-4'>
                    <div class="card-header">
                        <?php $author = User::find_by_id($post->author_id); ?>
                        <div title=' <?php echo($author->username); ?>' class="user_image_small bg-img" style="background-image: url('<?php echo $author->upload_photo(); ?>');" >
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo($post->title); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo($post->extra_text); ?></h6>
                    </div>
                    <div class="card-footer">
                        
                    
                    </div>
                </div>
            </div>
                
       <?php endif; ?>
     <?php endforeach; ?>
</div>
      <hr>   
</div>
<div class='col-sm-12'>
    <h2 class='inline mr-2'>Stop </h2>
    <button onclick="selectCategory('stop_select')" type='button' data-toggle="modal" data-target="#postModal" class='btn btn-info pull-right'>Add Post</button>

<div class='row mt-4'>
    <?php foreach($posts as $post): ?>
        <?php if($post->category == 'Stop') : ?>
            <div class="col-md-4 col-lg-3" >
                <div class='card'>
                <div class="card-body">
                    <h5 class="card-title"><?php echo($post->title); ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo($post->extra_text); ?></h6>
                </div>
                <div class="card-footer">
                    <small class="text-muted">These will be cmments</small>
                </div>
                </div> 
            </div>
       <?php endif; ?>
     <?php endforeach; ?>
</div>
      <hr>   
</div>
<div class='col-sm-12'>
    <h2 class='inline mr-2'>Continue </h2>
    <button onclick="selectCategory('cont_select')" type='button' data-toggle="modal" data-target="#postModal" class='btn btn-info pull-right'>Add Post</button>

<div class='row mt-4'>
    <?php foreach($posts as $post): ?>
        <?php if($post->category == 'Continue') : ?>
            <div class="col-md-4 col-lg-3" >
                <div class='card'>
                <div class="card-body">
                    <h5 class="card-title"><?php echo($post->title); ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo($post->extra_text); ?></h6>
                </div>
                <div class="card-footer">
                    <small class="text-muted">These will be cmments</small>
                </div>
                </div> 
            </div>
       <?php endif; ?>
     <?php endforeach; ?>
</div>
      <hr>   
</div>



<!-- Modal -->
<div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Post</h5>
        <button onclick="clearForm('add-post-form')" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form id='add-post-form' action='board.php' method='POST'>
      <div class="modal-body">
     
  
  <div class="form-group">
    <label for="postform-category">Category</label>
    <select name='category' class="form-control" id="postform-category">
      <option id='start_select' value='Start'>Start</option>
      <option id='stop_select' value='Stop'>Stop</option>
      <option id='cont_select' value='Continue'>Continue</option>
    </select>
  </div>
  <div class="form-group">
    <label for="post-form-title">Suggestion</label>
    <input name='title' class="form-control" id='post-form-title'>
  </div>
  
  <div class="form-group">
    <label for="postform-extra-info">Extra Info</label>
    <textarea name='extra_text' id='postform-extra-info' class="form-control" rows="3"></textarea>
  </div>
  <input type='hidden' name='sprint_id' value="<?php echo ($sprint_id); ?>">

      </div>
      <div class="modal-footer">
        <button onclick="clearForm('add-post-form')" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button name="submit" type="submit" class="btn btn-info">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>




<?php include("footer.php"); ?>

