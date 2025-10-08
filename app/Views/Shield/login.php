<?= $this->extend(config('Auth')->views['layout']) ?>
<?= $this->section('judul') ?>
<title>Login | <?= setting('App.siteNama') ?></title>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline rounded-lg">

            <?= $this->include('Shield/logo') ?>

            <div class="card-body">
                <h5 class="login-box-msg"><b>LOGIN</b></h5>
                <?= view('App\Views\Shield\error') ?>
                <form id="loginForm" action="<?= url_to('login') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-white">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                        </div>
                        <input type="email" name="email" class="form-control" placeholder="Email" value="<?= old('email') ?>" required>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-lock-fill"></i>
                        </span>
                        <input type="password" name="password" class="form-control passwd" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text bg-white border">
                                <span onclick="cekpwd()" class="ikon" style="cursor:pointer"><i class="bi bi-eye-fill"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <?= $this->include('Shield/recaptcha') ?>

                        <?php if (setting('App.authRemembering') === "true") : ?>
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember" name="remember">
                                    <label for="remember">
                                        Ingat Saya
                                    </label>
                                </div>
                            </div>
                        <?php endif ?>

                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>

                <?php if (setting('App.authMagicLink') === "true") : ?>
                    <div style="border-bottom: 1px solid rgba(0,0,0,.125);" class="my-3"></div>
                    <p class="mb-1">
                    <a href="<?= url_to('magic-link') ?>" class="float-right">Login tanpa password</a>
                    </p>
                <?php endif ?>

                <?php if (setting('App.authRegistration') === "true") : ?>
                    <a href="<?= url_to('register') ?>">Registrasi</a>
                <?php endif ?>
            </div>
        </div>
    </div>
    <?= $this->endSection() ?>

    <?= $this->section('js') ?>
    <script src="<?= base_url('plugin/jquery/jquery.validate.min.js') ?>"></script>
    <script src="<?= base_url('plugin/jquery/jquery.validate_id.min.js') ?>"></script>
    <script src="<?= base_url('plugin/jquery/additional-methods.min.js') ?>"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        function cekpwd() {
            let input = $(".passwd").get(0);
            if (input.type === "password") {
                $(".ikon").html("<i class='bi bi-eye-slash-fill'></i>");
                input.type = "text";
            } else {
                $(".ikon").html("<i class='bi bi-eye-fill'></i>");
                input.type = "password";
            }
        }

        <?php if (setting('App.gRecaptcha') === "true") : ?>
        $(function() {
            $('#loginForm').on('submit', function(e) {
                var response = grecaptcha.getResponse();
                if (response.length === 0) {
                    e.preventDefault(); // hentikan submit
                    alert('Silakan centang reCAPTCHA terlebih dahulu.');
                }
            });
        });
        <?php endif ?>

        function IsEmail(email) {
            const regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }

        $.validator.addMethod("customEmail", function(value, element) {
            return IsEmail(value);
        }, "Email tidak valid (contoh: user@example.com)!");

        $(function() {
            $('#loginForm').validate({
                rules: {
                    email: {
                        required: true,
                        customEmail: true
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.input-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
    <?= $this->endSection() ?>