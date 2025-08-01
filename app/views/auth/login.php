<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/styles.css">
    <title>Login</title>
</head>

<body>
    <section>
        <div class="container">

            <div class="form-container">
                <h1>Login</h1>
                <form method="POST" action="<?= BASE_URL ?>/auth/login" id="login-form">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username">
                    <span class="error-msg" id="username-error">
                        <?php echo $errors['username'] ?? ''; ?>
                    </span>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                    <span class="error-msg" id="password-error">
                        <?php echo $errors['password'] ?? ''; ?>
                    </span>

                    <p class="error-msg" id="credentials-error">
                        <?php echo $errors['credentials'] ?? ''; ?>
                    </p>

                    <button type="submit">Login</button>
                </form>
                <p class="form-text">You didn't have an account? <a href="<?= BASE_URL ?>/auth/register">Register</a></p>
            </div>
        </div>
        <section>

        <script src="<?= BASE_URL ?>/js/validation.js"></script>
</body>

</html>