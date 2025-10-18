<?= $this->extend(config('Auth')->views['layout']) ?>
<?= $this->section('judul') ?>
<title>Magic Link | <?= setting('App.siteNama'); ?></title>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline rounded-lg">

            <?= $this->include('Shield/logo') ?>

            <div class="card-body">
                <p class="pesan">Kami akan mengirimkan tautan login sementara tanpa password. Cek folder spam jika tidak ada di kotak masuk.</p>

                <form id="magicForm" action="<?= url_to('magic-link') ?>" method="post" class="mb-2">
                    <?= csrf_field() ?>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                        </div>
                        <input type="email" name="email" class="form-control" placeholder="Email" value="<?= old('email') ?>" required>
                    </div>

                    <div class="row">
                        <?= $this->include('Shield/recaptcha') ?>
                        <div class="col-12"> <button type="submit" class="btn btn-primary btn-block">Kirim Link</button> </div>
                    </div>
                </form>

                <?= view('App\Views\Shield\error') ?>

                <div style="border-bottom: 1px solid rgba(0,0,0,.125);" class="my-3"></div>

                <p class="mb-1"><a href="<?= url_to('login') ?>">Kembali ke login</a></p>
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
        <?php if (setting('App.gRecaptcha') === "true") : ?>
            $(function() {
                $('#magicForm').on('submit', function(e) {
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
            $('#magicForm').validate({
                rules: {
                    email: {
                        required: true,
                        customEmail: true
                    }
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