function start_loader() {
    $('body').append('<div id="preloader"><div class="loader-holder"><div></div><div></div><div></div><div></div>')
}

function end_loader() {
    $('#preloader').fadeOut('fast', function() {
        $('#preloader').remove();
    })
}
// function 
window.alert_toast = function($msg = 'TEST', $bg = 'success', $pos = '') {
    var Toast = Swal.mixin({
        toast: true,
        position: $pos || 'top-end',
        showConfirmButton: false,
        timer: 5000
    });
    Toast.fire({
        icon: $bg,
        title: $msg
    })
}

window.update_cart_count = function($count = 0) {
    if ($count > 0 && $('#cart_count').length > 0) {
        $('#cart_count').text($count)
    }
}

$(document).ready(function() {
    // Login
    $('#login-frm').submit(function(e) {
            e.preventDefault()
            start_loader()
            if ($('.err_msg').length > 0)
                $('.err_msg').remove()
            $.ajax({
                url: _base_url_ + 'classes/Login.php?f=login',
                method: 'POST',
                data: $(this).serialize(),
                error: err => {
                    console.log(err)

                },
                success: function(resp) {
                    if (resp) {
                        resp = JSON.parse(resp)
                        if (resp.status == 'success') {
                            location.replace(_base_url_ + 'admin');
                        } else if (resp.status == 'incorrect') {
                            var _frm = $('#login-frm')
                            var _msg = "<div class='alert alert-danger text-white err_msg'><i class='fa fa-exclamation-triangle'></i> Incorrect username or password</div>"
                            _frm.prepend(_msg)
                            _frm.find('input').addClass('is-invalid')
                            $('[name="username"]').focus()
                        }
                        end_loader()
                    }
                }
            })
        })
        //client login
    $('#clogin-frm').submit(function(e) {
            e.preventDefault()
            var _this = $(this)
            if ($('.err_msg').length > 0)
                $('.err_msg').remove()
            var el = $('<div class="alert err_msg">')
            el.hide()
            start_loader()
            
            // Clear any previous login messages
            $('#login-message').empty();
            
            $.ajax({
                url: _base_url_ + 'classes/Login.php?f=login_client',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                error: err => {
                    console.log('Login error:', err)
                    el.text('Une erreur est survenue lors de la connexion')
                    el.addClass('alert-danger')
                    _this.prepend(el)
                    el.show('slow')
                    end_loader()
                },
                success: function(resp) {
                    console.log('Login response:', resp);
                    if (resp.status == 'success') {
                        // Show success message
                        $('#login-message').html('<div class="alert alert-success">Connexion réussie! Redirection...</div>');
                        
                        // Force a hard reload to ensure session is recognized
                        setTimeout(function() {
                            // Use document.location with reload(true) for a complete page refresh
                            document.location.href = _base_url_;
                        }, 1000);
                    } else if (!!resp.msg) {
                        el.text(resp.msg)
                        el.addClass('alert-danger')
                        _this.prepend(el)
                        el.show('slow')
                        _this.find('input').addClass('is-invalid')
                        $('[name="username"]').focus()
                    } else {
                        el.text('An error occured')
                        el.addClass('alert-danger')
                        _this.append(el)
                        el.show('slow')
                        _this.find('input').addClass('is-invalid')
                        $('[name="username"]').focus()
                    }
                    end_loader()
                }
            })
        })
        //driver login
    $('#dlogin-frm').submit(function(e) {
            e.preventDefault()
            var _this = $(this)
            if ($('.err_msg').length > 0)
                $('.err_msg').remove()
            var el = $('<div class="alert err_msg">')
            el.hide()
            start_loader()
            $.ajax({
                url: _base_url_ + 'classes/Login.php?f=login_driver',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                error: err => {
                    console.log(err)
                    el.text('An error occured')
                    el.addClass('alert-danger')
                    _this.append(el)
                    el.show('slow')
                    end_loader()
                },
                success: function(resp) {
                    if (resp.status == 'success') {
                        location.replace(_base_url_ + "/driver");
                    } else if (!!resp.msg) {
                        el.text(resp.msg)
                        el.addClass('alert-danger')
                        _this.append(el)
                        el.show('slow')
                        _this.find('input').addClass('is-invalid')
                        $('[name="username"]').focus()
                    } else {
                        el.text('An error occured')
                        el.addClass('alert-danger')
                        _this.append(el)
                        el.show('slow')
                        _this.find('input').addClass('is-invalid')
                        $('[name="username"]').focus()
                    }
                    end_loader()
                }
            })
        })
        // System Info
    $('#system-frm').submit(function(e) {
        e.preventDefault()
        start_loader()
        if ($('.err_msg').length > 0)
            $('.err_msg').remove()
        $.ajax({
            url: _base_url_ + 'classes/SystemSettings.php?f=update_settings',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            error: (err) => {
                alert_toast("An error occured", 'error')
                end_loader()
            },
            success: function(resp) {
                if (resp == 1) {
                    // alert_toast("Data successfully saved",'success')
                    location.reload()
                } else {
                    $('#msg').html('<div class="alert alert-danger err_msg">An Error occured</div>')
                    end_loader()
                }
                $('html, body').scrollTop(0)
            }
        })
    })
})