<?php
require_once(dirname(__DIR__, 2) . '/config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $id = intval($_GET['id']);
    $qry = $conn->query("SELECT f.*, c.name as category from `facility_list` f inner join category_list c on f.category_id = c.id where f.id = '{$id}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k = stripslashes($v);
        }
    } else {
        echo "<script>alert('Facility not found!');</script>";
        echo "<script>window.location.href='./?page=facilities';</script>";
        exit;
    }
} else {
    echo "<script>window.location.href='./?page=facilities';</script>";
    exit;
}
?>

<style>
    .facility-img{
        width:100%;
        object-fit:scale-down;
        object-position:center center;
    }
</style><!-- Change this: -->
<a class="dropdown-item" href="?page=facilities/view_facility&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
<div class="dropdown-divider"></div>
<a class="dropdown-item" href="?page=facilities/manage_facility&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>

<!-- To this: -->
<a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
<div class="dropdown-divider"></div>
<a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
<div class="content py-3">
    <div class="card card-outline rounded-0 card-primary shadow">
        <div class="card-header">
            <h4 class="card-title">Facility Details</h4>
            <div class="card-tools">
                <?php if(isset($facility_id) && $facility_id > 0): ?>
                <a class="btn btn-primary btn-sm btn-flat" href="./?page=facilities/manage_facility&id=<?= $facility_id ?>" onclick="console.log('Edit button clicked with ID: <?= $facility_id ?>');"><i class="fa fa-edit"></i> Edit</a>
                <a class="btn btn-danger btn-sm btn-flat" href="javascript:void(0);" id="delete_data"><i class="fa fa-trash"></i> Delete</a>
                <?php endif; ?>
                <a class="btn btn-default border btn-sm btn-flat" href="./?page=facilities"><i class="fa fa-angle-left"></i> Back</a>
            </div>
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <img src="<?= validate_image(isset($image_path) ? $image_path : "") ?>" alt="facility Image <?= isset($name) ? $name : "" ?>" class="img-thumbnail facility-img">
                    </div>
                </div>
                <fieldset>
                    <div class="row">
                        <div class="col-md-12">
                            <small class="mx-2 text-muted">Name</small>
                            <div class="pl-4"><?= isset($name) ? $name : '' ?></div>
                        </div>
                        <div class="col-md-12">
                            <small class="mx-2 text-muted">Description</small>
                            <div class="pl-4"><?= isset($description) ? $description : '' ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <small class="mx-2 text-muted">Price</small>
                            <div class="pl-4"><?= isset($price) ? number_format($price,2) : '' ?></div>
                        </div>
                    </div>
                </fieldset>
                <div class="row">
                    <div class="col-md-12">
                        <small class="mx-2 text-muted">Status</small>
                        <div class="pl-4">
                            <?php if(isset($status)): ?>
                                <?php if($status == 1): ?>
                                    <span class="badge badge-success px-3 rounded-pill">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-danger px-3 rounded-pill">Inactive</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#edit_facility').click(function(){
            uni_modal("Edit Facility","facilities/manage_facility.php?id=<?= isset($id) ? $id : '' ?>");
        })
		$('#delete_data').click(function(){
			_conf("Are you sure to delete this facility permanently?","delete_facility",[])
		})
    })
    function delete_facility($id = '<?= isset($id) ? $id : "" ?>'){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_facility",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.href= './?page=facilities';
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>