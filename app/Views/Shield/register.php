<?= $this->extend(config('Auth')->views['layout']) ?>
<?= $this->section('judul') ?>
<title><?= setting('App.siteNama'); ?> | <?= lang('Auth.register') ?></title>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>

<body class="hold-transition register-page">
	<div class="register-box">
		<div class="register-logo"> <img src="<?= base_url('upload/logo/') . setting('App.logoWarna') ?>" style="max-width:90%" title="<?= setting('App.siteNama'); ?>"> </div>
		<div class="card card-outline card-primary">
			<div class="card-body mt-2">
				<?= view('App\Views\Shield\error') ?>
				<form action="<?= url_to('register') ?>" method="post" class="mb-2">
					<label for="email"><?= lang('Auth.email') ?></label>
					<div class="input-group mb-3">
						<input type="email" class="form-control" name="email" inputmode="email" autocomplete="email" value="<?= old('email') ?>" required>
						<div class="input-group-append">
							<div class="input-group-text"> <span class="fas fa-envelope"></span> </div>
						</div>
					</div>

					<label for="username"><?= lang('Auth.username') ?></label>
					<div class="input-group mb-3">
						<input type="text" class="form-control" name="username" inputmode="text" autocomplete="username" value="<?= old('username') ?>" required>
						<div class="input-group-append">
							<div class="input-group-text"> <span class="fas fa-user"></span> </div>
						</div>
					</div>

					<label for="password"><?= lang('Auth.password') ?></label>
					<div class="input-group mb-3">
						<input type="password" class="form-control" name="password" inputmode="text" autocomplete="new-password" required>
						<div class="input-group-append">
							<div class="input-group-text"> <span class="fas fa-lock"></span> </div>
						</div>
					</div>

					<label for="passwordConfirm"><?= lang('Auth.passwordConfirm') ?></label>
					<div class="input-group mb-3">
						<input type="password" class="form-control" name="password_confirm" inputmode="text" autocomplete="new-password" required>
						<div class="input-group-append">
							<div class="input-group-text"> <span class="fas fa-lock"></span> </div>
						</div>
					</div>

					<div class="row">
						<div class="col-4"> <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.register') ?></button> </div>
						<div class="col-8"> <a href="<?= url_to('login') ?>" class="float-right icheck-primary"><?= lang('Auth.haveAccount') ?> </a> </div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?= $this->endSection() ?>