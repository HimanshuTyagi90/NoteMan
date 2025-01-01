<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <title>Sign Up</title>
</head>

<body style="background-color: rgb(148, 173, 142);">
    <?php include '../_partials/_navBar.php'; ?>

    <!-- Add a margin-top to ensure spacing below the navbar -->
    <div class="container d-flex align-items-center justify-content-center mt-4 mb-4" style="margin-top: 60px;">
        <div class="card shadow-lg p-2" style="width: 100%; max-width: 500px; border-radius: 12px; background-color: #d4edda; border: 1px solid #c3e6cb;">
            <h2 class="text-center mb-4 text-primary" >Create New Account</h2>
            <form id="signUpForm">
                <div class="mb-3" style="background-color: rgba(240, 240, 240, 0.59); border-radius: 12px; padding: 10px;">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter your first name" required>
                </div>
                <div class="mb-3" style="background-color: rgba(240, 240, 240, 0.59); border-radius: 12px; padding: 10px;">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter your last name" required>
                </div>
                <div class="mb-3" style="background-color: rgba(240, 240, 240, 0.59); border-radius: 12px; padding: 10px;">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email@example.com" required>
                </div>
                <div class="mb-3" style="background-color: rgba(240, 240, 240, 0.59); border-radius: 12px; padding: 10px;">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter a strong password" required>
                </div>
                <div class="mb-3" style="background-color: rgba(240, 240, 240, 0.59); border-radius: 12px; padding: 10px;">
                    <label for="phoneNo" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phoneNo" name="phoneNo" placeholder="Enter your phone number" required>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary w-100 fw-bold fs-5 mb-2">Sign Up</button>
                    <button type="reset" class="btn btn-danger w-100 fw-bold fs-5">Reset</button>
                </div>
                <div class="text-center">
                    <a href="index.php" class="text-success fw-bold" style="text-decoration: none;">
                        Already have an account? Log in
                    </a>
                </div>
                <p id="signUpStatus" class="text-center mt-3 text-danger fw-bold"></p>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('signUpForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Get form data
            const formData = {
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
                firstName: document.getElementById('firstName').value,
                lastName: document.getElementById('lastName').value,
                phoneNo: document.getElementById('phoneNo').value,
            };

            // Send data to PHP server via fetch
            fetch('../controllers/signup_controller.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(formData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.text(); // Parse the response as text
            })
            .then(data => {
                console.log('Server Response:', data); // Log raw response for debugging

                try {
                    const parsedData = JSON.parse(data); // Try parsing the response as JSON
                    if (parsedData.success) {
                        // Save userId to localStorage
                        // localStorage.setItem('userId', parsedData.userId);
                        alert('Account created successfully!');
                        window.location.href = 'homepage.php'; // Redirect to home page
                    } else {
                        alert('Error: ' + parsedData.message); // Handle error message
                    }
                } catch (e) {
                    console.error('Error parsing JSON:', e); // Log parsing errors
                    alert('There was an issue with the server response.');
                }
            })
            .catch(err => {
                console.error('Error:', err); // Log fetch errors
                alert('There was an error creating the account. Please try again.');
            });
        });
    </script>

    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
