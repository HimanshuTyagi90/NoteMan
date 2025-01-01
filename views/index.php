<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <title>Login Please</title>
</head>
<body style="background-color: rgb(217, 213, 213);">
    <?php include '../_partials/_navBar.php'; ?>
    <div class="container d-flex align-items-center justify-content-center vh-100">
        <div class="card shadow-lg p-4" style="width: 100%; max-width: 500px; border-radius: 12px;">
            <h2 class="text-center mb-4">NoteMan Login</h2>
            <form id="loginForm">
                <div class="mb-3" style="background-color: rgba(240, 240, 240, 0.59); border-radius: 12px; padding: 10px;">
                    <label for="staticEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="staticEmail" name="email" placeholder="Email@example.com" required>
                </div>
                <div class="mb-3">
                    <label for="inputPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password here" required>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary w-100 fw-bold fs-5 mb-2">Login</button>
                    <button type="reset" class="btn btn-danger w-100 fw-bold fs-5">Reset</button>
                </div>
                <div class="text-center">
                    <a href="signUpForm.php" class="text-success fw-bold" style="text-decoration: none;">
                        Create New Account
                    </a>
                </div>
                <p id="loginStatus" class="text-center mt-3 text-danger fw-bold"></p>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Get form data
            const formData = {
                email: document.getElementById('staticEmail').value,
                password: document.getElementById('inputPassword').value,
            };

            // Send data to PHP server via fetch
            fetch('../controllers/login_controller.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(formData)
            })
            .then(response => response.json()) // Parse response as JSON
            .then(data => {
                console.log('Server Response:', data); // Log raw response for debugging

                if (data.success) {
                    window.location.href = 'homepage.php'; // Redirect to home page
                } else {
                    alert('Error: ' + data.message); // Handle error message
                }
            })
            .catch(err => {
                console.error('Error:', err); // Log fetch errors
                alert('There was an error logging in. Please try again.');
            });
        });
    </script>

    <!-- Link JavaScript file -->
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
