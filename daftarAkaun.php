<?php
session_start();
include('db.php');

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_penuh = $_POST['nama_penuh'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $bengkel = $_POST['bengkel'];
    $role = 'pelajar'; // or 'ketua bahagian' depending on the form

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // First, check if the email already exists
    $checkQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // If the email already exists, show an error
    if ($result->num_rows > 0) {
        echo "The email address is already registered. Please use a different email.";
    } else {
        // Insert the new user into the database
        $query = "INSERT INTO users (nama_penuh, email, password, role, bengkel) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssss', $nama_penuh, $email, $hashed_password, $role, $bengkel);

        if ($stmt->execute()) {
            echo "Registration successful!";
            // You can redirect to the login page or any other page
            header("Location: index.php");
            exit();
        } else {
            echo "Error during registration. Please try again.";
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Daftar Akaun</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Daftar Akaun</h2>
        <form method="POST">
            <div class="form-group">
                <label>Nama Penuh:</label>
                <input type="text" name="nama_penuh" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Role:</label>
                <select name="role" class="form-control">
                    <option value="pelajar">Pelajar</option>
                    <option value="ketua bahagian">Ketua Bahagian</option>
                    <option value="bppl">BPPL</option>
                </select>
            </div>
            <div class="form-group">
                <label>Bengkel:</label>
                <select name="bengkel" class="form-control">
                    <option value="TPP">TPP</option>
                    <option value="TPM">TPM</option>
                    <option value="TKR">TKR</option>
                    <option value="CADDS">CADDS</option>
                    <option value="BPPL">BPPL</option>
                </select>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Confirm Password:</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Daftar Akaun</button>
        </form>
    </div>
</body>
</html>
