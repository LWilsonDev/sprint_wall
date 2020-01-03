function clearForm(form_id){
	document.getElementsByClassName(form_id).reset();
}

function selectCategory(cat_id){
	document.getElementsByClassName(cat_id).selected = "true";
}


// $(document).on("click", ".open-card", function () {
//      var cardId = $(this).data('id');
//      $(".modal-body #cardId").val( cardId );
//      // As pointed out in comments, 
//      // it is unnecessary to have to manually call the modal.
//      // $('#addBookDialog').modal('show');
// });
$(document).ready(function(){  
      $('.view_data').click(function(){  
           var post_id = $(this).attr("id-data"); 
           var title = $(this).attr('title-data'); 
           var extra = $(this).attr('extra-data');
           var author = $(this).attr('author-data');
           $.ajax({  
                url:"../board.php",
                method:"post",  
                data:{'post_id':post_id},  
                success:function(response){  
                	$('.modal-post-title').html(title);
                	$('.modal-post-extra').html(extra);
                	$('.modal-post-author').html(author);
                     $('#employee_detail').html(post_id);  
                     $('#dataModal').modal("show");  
                }  
           });  
      });  
 }); 

