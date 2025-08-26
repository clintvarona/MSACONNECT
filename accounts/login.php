<?php
require_once '../tools/function.php';
require_once '../classes/accountClass.php';

session_start();

$username = $password = '';
$accountObj = new Account();
$loginErr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = clean_input($_POST['username']);
    $password = clean_input($_POST['password']);

    if ($accountObj->login($username, $password)) {
        $data = $accountObj->fetch($username);
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['account'] = $data;
        $_SESSION['role'] = $data['role']; 

        if ($data['role'] == 'admin' || $data['role'] == 'sub-admin') {
            header('location: ../views/admin/admin_dashboard');
            exit();
        } elseif ($data['role'] != 'sub-admin' && $data['role'] != 'admin') {
            header('location: ../views/user/landing_page');
            exit();
        } else {
            $loginErr = 'Invalid username or password';
        }
    } else {
        $loginErr = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"> 
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <div class="container-fluid login-container">
        <div class="row g-0">
            <div class="col-md-6 login-image d-none d-md-block"></div>

            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <div class="login-box">
                    <h2 class="text-center mb-4">Login</h2>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username/Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="username" id="username" class="form-control" value="<?= $username ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                        </div>

                        <?php if (!empty($loginErr)) : ?>
                            <p class="error text-center text-danger"><?= $loginErr ?></p>
                        <?php endif; ?>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>