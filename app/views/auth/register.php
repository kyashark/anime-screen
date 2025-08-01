<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/styles.css">

    <title>Register</title>
</head>

<body>
    <section>
        <div class="container">
            <div class="form-container">
                <h1>Register</h1>
                <form method="POST" action="<?= BASE_URL ?>/auth/register" id="register-form">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo $username ?? ''; ?>" required>
                    
                    <span class="error-msg" id="username-error">
                        <?php echo $errors['username'] ?? ''; ?>
                    </span>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $email ?? ''; ?>" required>
                    <span class="error-msg" id="email-error">
                        <?php echo $errors['email'] ?? ''; ?>
                    </span>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <span class="error-msg" id="password-error">
                        <?php echo $errors['password'] ?? ''; ?>
                    </span>

                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                    <span class="error-msg" id="confirm-password-error">
                        <?php echo $errors['confirm-password'] ?? ''; ?>
                    </span>

                    <!-- <p>
                        <?php echo $errors['credentials'] ?? ''; ?>
                    </p>  -->

                    <button type="submit">Register</button>
                </form>
                <p class="form-text">You already have an account ? <a href="<?= BASE_URL ?>/auth/login">Login</a></p>
            </div>
        </div>
        <section>
        
        <script src="<?= BASE_URL ?>/js/validation.js"></script>
</body>

</html>