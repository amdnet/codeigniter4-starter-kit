<?php if (session('error') !== null) : ?>
    <div class="peringatan mb-3"><?= session('error') ?></div>
<?php elseif (session('errors') !== null) : ?>
    <div class="peringatan mb-3">
        <?php if (is_array(session('errors'))) : ?>
            <?php foreach (session('errors') as $error) : ?>
                <?= $error ?>
                <br>
            <?php endforeach ?>
        <?php else : ?>
            <?= session('errors') ?>
        <?php endif ?>
    </div>
<?php endif ?>