<?php require_once('./config.php') ?>
<!DOCTYPE html>
<html lang="fr">
 <?php require_once('inc/header.php') ?>
<body class="">
  <script>
    start_loader()
  </script>
  <style>
    html, body{
      width:calc(100%);
      height:calc(100%);
    }
      body{
         
          background-image:url('<?= validate_image($_settings->info('cover')) ?>');
          background-repeat: no-repeat;
          background-size:cover;
      }
      #logo-img{
          width:15em;
          height:15em;
          object-fit:scale-down;
          object-position:center center;
          background-color: transparent;
          backdrop-filter: brightness(0.5);
      }
      #cimg{
          width:15vw;
          height:20vh;
          object-fit:scale-down;
          object-position:center center;
      }
      .pass_type{
        cursor: pointer;
      }
      .card-outline.card-primary {
          border-top: 3px solid var(--brand-orange);
          box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
          border-radius: 10px;
      }
      .btn-primary {
          background: linear-gradient(135deg, #ff8800, #ff5500) !important;
          border: none !important;
          border-radius: 30px !important;
          padding: 8px 15px !important;
          font-weight: 600 !important;
          text-transform: uppercase;
          letter-spacing: 0.5px;
          transition: all 0.3s ease;
          box-shadow: 0 4px 10px rgba(255, 136, 0, 0.3);
      }
      .btn-primary:hover {
          background: linear-gradient(135deg, #ff5500, #ff8800) !important;
          transform: translateY(-2px);
          box-shadow: 0 6px 15px rgba(255, 136, 0, 0.4);
      }
      .btn-block {
          display: block;
          width: 100%;
      }
      a {
          color: #ff7700;
          transition: color 0.2s ease;
      }
      a:hover {
          color: #ff5500;
          text-decoration: none;
      }
  </style>
<div class="d-flex align-items-center justify-content-center h-100">
  <!-- /.login-logo -->
  <div class="d-flex h-100 justify-content-center align-items-center col-lg-5">
      <center><img src="uploads/system-logo.png" alt="Logo du système" class="img-thumbnail rounded-circle" id="logo-img"></center>
      <div class="clear-fix my-2"></div>
  </div>
  <div class="d-flex h-100 justify-content-center align-items-center col-lg-7 bg-gradient-light text-dark">
    <div class="card card-outline card-primary w-75">
      <div class="card-header text-center">
        <a href="./" class="text-decoration-none text-dark"><b>Créer un Compte</b></a>
      </div>
      <div class="card-body">
        <form id="register-frm" action="" method="post">
          <input type="hidden" name="id">
          <div class="row">
            <div class="form-group col-md-6">
                <input type="text" name="firstname" id="firstname" placeholder="Entrez votre prénom" autofocus class="form-control form-control-sm form-control-border" required>
                <small class="ml-3">Prénom</small>
            </div>
            <div class="form-group col-md-6">
                <input type="text" name="middlename" id="middlename" placeholder="Deuxième prénom (optionnel)" class="form-control form-control-sm form-control-border">
                <small class="ml-3">Deuxième prénom</small>
            </div>
            <div class="form-group col-md-6">
                <input type="text" name="lastname" id="lastname" placeholder="Entrez votre nom" class="form-control form-control-sm form-control-border" required>
                <small class="ml-3">Nom</small>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
                  <select name="gender" id="gender" class="custom-select custom-select-sm form-control-border" required>
                    <option>Homme</option>
                    <option>Femme</option>
                  </select>
                  <small class="ml-3">Genre</small>
            </div>
            <div class="form-group col-md-6">
                <input type="text" name="contact" id="contact" placeholder="Entrez votre numéro" class="form-control form-control-sm form-control-border" required>
                <small class="ml-3">Téléphone</small>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-12">
              <small class="ml-3">Adresse</small>
              <textarea name="address" id="address" rows="3" class="form-control form-control-sm rounded-0" placeholder="Rue, Quartier, Ville, Code Postal"></textarea>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="form-group col-md-6">
                <input type="email" name="email" id="email" placeholder="exemple@domaine.com" class="form-control form-control-sm form-control-border" required>
                <small class="ml-3">Email</small>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
                <div class="input-group">
                  <input type="password" name="password" id="password" placeholder="" class="form-control form-control-sm form-control-border" required>
                  <div class="input-group-append border-bottom border-top-0 border-left-0 border-right-0">
                    <span class="input-append-text text-sm"><i class="fa fa-eye-slash text-muted pass_type" data-type="password"></i></span>
                  </div>
                </div>
                <small class="ml-3">Mot de passe</small>
            </div>
            <div class="form-group col-md-6">
                <div class="input-group">
                  <input type="password" id="cpassword" placeholder="" class="form-control form-control-sm form-control-border" required>
                  <div class="input-group-append border-bottom border-top-0 border-left-0 border-right-0">
                    <span class="input-append-text text-sm"><i class="fa fa-eye-slash text-muted pass_type" data-type="password"></i></span>
                  </div>
                </div>
                <small class="ml-3">Confirmer le mot de passe</small>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
              <label for="" class="control-label">Avatar</label>
              <div class="custom-file">
                      <input type="file" class="custom-file-input rounded-0 form-control form-control-sm form-control-border" id="customFile" name="img" onchange="displayImg(this,$(this))">
                      <label class="custom-file-label" for="customFile">Choisir un fichier</label>
                    </div>
            </div>
          <div class="row">
          </div>
            <div class="form-group col-md-6 d-flex justify-content-center">
              <img src="<?php echo validate_image(isset($image_path) ? $image_path : "") ?>" alt="" id="cimg" class="img-fluid img-thumbnail bg-gradient-gray">
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col-8">
              <a href="<?php echo base_url ?>">Retour au site</a>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">S'inscrire</button>
            </div>
            <!-- /.col -->
          </div>
          <div class="row">
              <div class="col-12 text-center">
              <a href="<?php echo base_url.'login.php' ?>">Déjà un compte ?</a>
              </div>
          </div>
        </form>
        <!-- /.social-auth-links -->

        <!-- <p class="mb-1">
          <a href="forgot-password.html">I forgot my password</a>
        </p> -->
        
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>

</div>

<script src="<?= base_url ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<!-- <script src="<?= base_url ?>dist/js/adminlte.min.js"></script> -->

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
    end_loader();
    $('.pass_type').click(function(){
      var type = $(this).attr('data-type')
      if(type == 'password'){
        $(this).attr('data-type','text')
        $(this).closest('.input-group').find('input').attr('type',"text")
        $(this).removeClass("fa-eye-slash")
        $(this).addClass("fa-eye")
      }else{
        $(this).attr('data-type','password')
        $(this).closest('.input-group').find('input').attr('type',"password")
        $(this).removeClass("fa-eye")
        $(this).addClass("fa-eye-slash")
      }
    })
    $('#register-frm').submit(function(e){
      e.preventDefault()
      var _this = $(this)
			 $('.err-msg').remove();
       var el = $('<div>')
            el.hide()
      if($('#password').val() != $('#cpassword').val()){
        el.addClass('alert alert-danger err-msg').text('Les mots de passe ne correspondent pas.');
        _this.prepend(el)
        el.show('slow')
        return false;
      }
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Users.php?f=save_client",
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
						location.href = "./login.php";
					}else if(resp.status == 'failed' && !!resp.msg){   
              el.addClass("alert alert-danger err-msg").text(resp.msg)
              _this.prepend(el)
              el.show('slow')
          }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
          $('html, body').scrollTop(0)
				}
			})
    })
  })
</script>
</body>
</html>