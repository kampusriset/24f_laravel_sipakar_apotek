<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Apotek Pintar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-5">
                        <h2 class="fw-bold mb-4 text-center">Apotek Pintar</h2>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                            <div class="alert alert-danger py-2">
                                <?php echo e($errors->first()); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <form action="/login" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2 mb-3">Masuk</button>
                        </form>

                        <div class="text-center text-muted mb-3">atau</div>

                        <a href="/auth/google/redirect" class="btn btn-outline-dark w-100 py-2 d-flex align-items-center justify-content-center gap-2">
                            <img src="https://www.google.com/favicon.ico" width="18" height="18" alt="Google">
                            Masuk dengan Google
                        </a>

                        <p class="text-center text-muted mt-4 mb-0">
                            Belum punya akun? <a href="/register">Daftar di sini</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html><?php /**PATH C:\laragon\www\apotek33333\resources\views/login-pilihan.blade.php ENDPATH**/ ?>