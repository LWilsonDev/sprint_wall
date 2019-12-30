
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

      </div>
      <div class="modal-footer">
        <button onclick="clearForm('add-post-form')" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button name="formSubmit" type="submit" class="btn btn-info">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>