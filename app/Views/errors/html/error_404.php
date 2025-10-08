<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="Aplikasi yang dibuat khusus untuk Cirebon Web" />
    <meta name="author" content="www.cirebonweb.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex,nofollow" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            color: white;
            font-family: Arial, sans-serif;
            background: linear-gradient(0deg, #000, rgba(0, 0, 0, .53)), url('https://getwallpapers.com/wallpaper/full/d/1/c/51021.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            height: 100%
        }

        .error-container {
            padding: 40px 15px;
            text-align: center;
        }

        .error-actions {
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .error-actions .btn {
            margin-right: 10px;
        }
    </style>
</head>

<body style="display: flex; align-items: center; justify-content: center; height: 100vh;">
    <div class="container">
        <div class="error-container">
            <h1 class="display-1">Oops!</h1>
            <h2 class="display-4">404 Not Found</h2>
            <div class="error-details mb-4">
                <?php if (ENVIRONMENT !== 'production') : ?>
                    <?= nl2br(esc($message)) ?>
                <?php else : ?>
                    <?= lang('Errors.sorryCannotFind') ?>
                <?php endif; ?>
            </div>
            <div class="error-actions d-flex flex-wrap gap-2 justify-content-center">
                <a href="<?= base_url('/') ?>" class="btn btn-primary btn-lg" style="width:240px">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-house me-2" viewBox="0 0 16 16">
                        <path
                            d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5Z" />
                    </svg>
                    Home
                </a>
            </div>
        </div>
    </div>
</body>

</html>