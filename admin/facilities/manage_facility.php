<?php
require_once(dirname(__DIR__, 2) . '/config.php');
// Clear any existing flashdata to prevent duplicate messages
if(isset($_SESSION['flashdata']['success'])){
    unset($_SESSION['flashdata']['success']);
}

// Debug the incoming ID
echo "<script>console.log('GET ID: " . (isset($_GET['id']) ? $_GET['id'] : 'not set') . "');</script>";

if(isset($_GET['id']) && !empty($_GET['id']) && $_GET['id'] > 0){
    $facility_id = intval($_GET['id']);
    
    // Debug the parsed ID
    echo "<script>console.log('Parsed facility ID: {$facility_id}');</script>";
    
    // Query the facility data
    $qry = $conn->query("SELECT f.*, c.name as category_name FROM `facility_list` f LEFT JOIN category_list c ON f.category_id = c.id WHERE f.id = '{$facility_id}'");
    
    if($qry && $qry->num_rows > 0){
        $facility_data = $qry->fetch_assoc();
        
        // Debug the retrieved data
        echo "<script>console.log('Facility data found:', " . json_encode($facility_data) . ");</script>";
        
        // Set variables for form fields
        foreach($facility_data as $k => $v){
            $$k = $v;
        }
        // Also set category_name if present
        if(isset($facility_data['category_name'])) {
            $category_name = $facility_data['category_name'];
        }
    } else {
        echo "<script>console.log('No facility found with ID: {$facility_id}');</script>";
        echo "<script>alert('Facility not found!');</script>";
        echo "<script>window.location.href='./?page=facilities';</script>";
        exit;
    }
}
?>
<style>
	#cimg{
		/* min-width: 34vw;
		min-height: 25vh;
		max-height: 35vh; */
		max-width: 100%;
		object-fit:scale-down;
		object-position:center center;
	}
</style>
<div class="card card-outline card-info rounded-0">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($id) ? "Update ": "Create New " ?> Facility</h3>
	</div>
	<div class="card-body">
		<form action="" id="facility-form">
			<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
            <div class="form-group">
				<label for="category_id" class="control-label">Category</label>
                <select name="category_id" id="category_id" class="custom-select select2">
                    <option value="" <?= !isset($category_id) ? "selected" : "" ?> disabled></option>
                    <?php 
                    $categorys = $conn->query("SELECT * FROM category_list where delete_flag = 0 ".(isset($category_id) ? " or id = '{$category_id}'" : "")." order by `name` asc ");
                    while($row= $categorys->fetch_assoc()):
                    ?>
                    <option value="<?= $row['id'] ?>" <?= isset($category_id) && $category_id == $row['id'] ? "selected" : "" ?>><?= $row['name'] ?> <?= $row['delete_flag'] == 1 ? "<small>Deleted</small>" : "" ?></option>
                    <?php endwhile; ?>
                </select>
			</div>
            <div class="form-group">
				<label for="name" class="control-label">Name</label>
                <input name="name" id="name" type="text" class="form-control rounded-0" value="<?php echo isset($name) ? $name : ''; ?>" required>
			</div>
			<div class="form-group">
				<label for="description" class="control-label">Description</label>
                <textarea name="description" id="description" rows="5" class="form-control rounded-0 summernote" required><?php echo isset($description) ? $description : ''; ?></textarea>
			</div>
			<div class="form-group">
				<label for="price" class="control-label">Rent Price</label>
                <input name="price" id="price" type="text" class="form-control rounded-0" value="<?php echo isset($price) ? $price : ''; ?>" required />
			</div>
			<div class="form-group col-md-6">
				<label for="" class="control-label">Facility's Image</label>
				<div class="custom-file">
	              <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
	              <label class="custom-file-label" for="customFile">Choose file</label>
	            </div>
			</div>
			<div class="form-group col-md-12 d-flex justify-content-center">
				<img src="<?php echo validate_image(isset($image_path) ? $image_path : "") ?>" alt="" id="cimg" class="img-fluid img-thumbnail bg-gradient-gray">
			</div>
            <div class="form-group">
				<label for="status" class="control-label">Status</label>
                <select name="status" id="status" class="custom-select selevt">
                <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
                <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
                </select>
			</div>
		</form>
	</div>
	<div class="card-footer">
		<button class="btn btn-flat btn-primary" form="facility-form">Save</button>
		<button type="button" class="btn btn-flat btn-default" id="cancel-modal">Cancel</button>
	</div>
</div>
<script>
	window.displayImg = function(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        	_this.siblings('.custom-file-label').html(input.files[0].name)
	        }

	        reader.readAsDataURL(input.files[0]);
	    }else{
            $('#cimg').attr('src', "<?php echo validate_image(isset($image_path) ? $image_path : "") ?>");
            _this.siblings('.custom-file-label').html("Choose file")
        }
	}
	$(document).ready(function(){
	// Cancel button closes the modal
	$('#cancel-modal').on('click', function() {
		$('#uni_modal').modal('hide');
	});
		$('.select2').select2({
			width:'100%',
			placeholder:"Please Select Here"
		})
		$('.pass_view').click(function(){
			var group = $(this).closest('.input-group');
			var type = group.find('input').attr('type')
			if(type == 'password'){
				group.find('input').attr('type','text').focus()
				$(this).html('<i class="fa fa-eye"></i>')
			}else{
				group.find('input').attr('type','password').focus()
				$(this).html('<i class="fa fa-eye-slash"></i>')
			}
		})
		$('#facility-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_facility",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						end_loader();
						// Show success message
						alert_toast(resp.msg, 'success');
						
						// For both new and edited facilities, hide modal and redirect to facilities page
						setTimeout(function() {
							$('#uni_modal').modal('hide');
							
							// Add a small delay before redirecting to ensure modal is properly hidden
							setTimeout(function() {
								location.href = './?page=facilities';
							}, 300);
						}, 300);
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})

        $('.summernote').summernote({
		        height: "40vh",
		        toolbar: [
		            [ 'style', [ 'style' ] ],
		            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
		            [ 'fontname', [ 'fontname' ] ],
		            [ 'fontsize', [ 'fontsize' ] ],
		            [ 'color', [ 'color' ] ],
		            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
		            [ 'table', [ 'table' ] ],
		            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
		        ]
		    })
	})
</script>
