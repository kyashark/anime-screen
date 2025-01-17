<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <title>Login</title>
</head>

<body>
    <section>
        <div class="auth-container">

            <div class="form-container">
                <h5>Login</h5>
                <form method="POST" action="<?= BASE_URL ?>/auth/login">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username">
                    <span class="error-msg">
                        <?php echo $errors['username'] ?? ''; ?>
                    </span>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                    <span class="error-msg">
                        <?php echo $errors['password'] ?? ''; ?>
                    </span>

                    <p>
                        <?php echo $errors['credentials'] ?? ''; ?>
                    </p>

                    <button type="submit">Login</button>
                </form>
                <p>You didn't have an account ? <a href="<?= BASE_URL ?>/auth/register">Register</a></p>
            </div>
        </div>
        <section>
</body>

</html>