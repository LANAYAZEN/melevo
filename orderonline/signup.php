<?php session_start() ?>
<div class="container-fluid">
	<form action="" id="signup-frm">
		<div class="form-group">
			<label for="" class="control-label">Firstname</label>
			<input type="text" name="first_name" required class="form-control">
		</div>
		<div class="form-group">
			<label for="" class="control-label">Lastname</label>
			<input type="text" name="last_name" required class="form-control">
		</div>
		<div class="form-group">
			<label for="" class="control-label">Contact</label>
			<input type="text" name="mobile" required class="form-control">
		</div>
		<div class="form-group">
			<label for="" class="control-label">Address</label>
			<textarea cols="30" rows="3" name="address" required class="form-control"></textarea>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Email</label>
			<input type="email" name="email" required class="form-control">
		</div>
		<div class="form-group">
			<label for="" class="control-label">Password</label>
			<input type="password" name="password" required class="form-control">
		</div>
		<button type="submit" class="btn btn-info btn-sm">Create</button>
	</form>
</div>

<style>
	#uni_modal .modal-footer{
		display:none;
	}
</style>
<script>
	$('#signup-frm').submit(function(e){
    e.preventDefault()
    var btn = $('#signup-frm button[type="submit"]');
    btn.attr('disabled',true).html('Saving...');
    
    if($(this).find('.alert-danger').length > 0)
        $(this).find('.alert-danger').remove();
        
    $.ajax({
        url:'admin/ajax.php?action=signup',
        method:'POST',
        data:$(this).serialize(),
        error:function(err){
            console.log(err);
            btn.removeAttr('disabled').html('Create');
            $('#signup-frm').prepend('<div class="alert alert-danger">An error occurred. Please try again.</div>');
        },
        success:function(resp){
            if(resp == 1 || resp === "1"){
                $('#signup-frm').prepend('<div class="alert alert-success">Sign up successfully!</div>');
                setTimeout(function(){
                    location.href = '<?php echo isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php?page=home' ?>';
                }, 1500); // Redirect after 1.5 seconds
            } else {
                try {
                    var data = JSON.parse(resp);
                    $('#signup-frm').prepend('<div class="alert alert-danger">'+data.message+'</div>');
                } catch(e) {
                
					$('#signup-frm').prepend('<div class="alert alert-danger">Registration failed. Please try again.</div>');
					location.href = '<?php echo isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php?page=home' ?>';
				}

                btn.removeAttr('disabled').html('Create');
            }
        }
    })
})
</script>