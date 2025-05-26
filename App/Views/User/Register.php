<?php
$config = require 'config.php';
$baseURL = $config['baseURL'];
?>

<?php include 'Layout/HomeHeader.php'; ?>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Create Account</h3>
                                </div>
                                <?php if (!empty($_SESSION['register_error'])): ?>
                                    <div class="alert alert-danger"><?= $_SESSION['register_error'] ?></div>
                                    <!-- xóa thông báo lỗi sau khi hiện thị ở lần load tiếp theo -->
                                    <?php unset($_SESSION['register_error']); ?>
                                <?php endif; ?>
                                <div class="card-body">
                                    <form action="<?= $baseURL . "User/register" ?>" method="post">
                                        <div class="mb-3">
                                            <div class="form-floating w-100">
                                                <input class="form-control" id="inputFullName" name="fullname" type="text" placeholder="Your Full Name" />
                                                <label for="inputFullName">FullName</label>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-floating w-100">
                                                <input class="form-control" id="inputUserName" name="username" type="text" placeholder="Your Username" />
                                                <label for="inputUserName">UserName</label>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-floating w-100">
                                                <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Create a password" />
                                                <label for="inputPassword">Password</label>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-floating w-100">
                                                <input class="form-control" id="inputPasswordConfirm" name="confirm_password" type="password" placeholder="Confirm password" />
                                                <label for="inputPasswordConfirm">Confirm Password</label>
                                            </div>
                                        </div>

                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <button class="btn btn-primary btn-block" type="submit">Đăng ký</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="<?= $baseURL . "/user/login" ?>">Have an account? Go to login</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <?php include 'Layout/HomeFooter.php'; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src=<?= $baseURL . "admin/js/scripts.js" ?>></script>
</body>

</html>