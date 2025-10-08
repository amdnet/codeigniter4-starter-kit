<?php if (setting('App.gRecaptcha') === "true") : ?>
    <div class="col-12 mb-3">
        <?php helper('crb_recaptcha') ?>
        <?= recaptcha_field() ?>
    </div>
<?php endif ?>