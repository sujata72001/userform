<?php
include 'db_config.php';

// Retrieve form data
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];
$telephone = $_POST['telephone'];
$email = $_POST['email'];
$recaptchaToken = $_POST['recaptcha_token'];

// Server-side validation (you can customize this as per your requirements)
$errors = [];
if (empty($firstName)) {
    $errors[] = "First Name is required.";
}
if (empty($dob)) {
    $errors[] = "Date of Birth is required.";
}
if (empty($gender)) {
    $errors[] = "Gender is required.";
}
if (empty($telephone)) {
    $errors[] = "Telephone Number is required.";
}
if (empty($email)) {
    $errors[] = "Email is required.";
}
// Add more validation rules if needed

if (count($errors) > 0) {
    // Handle validation errors
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
    exit;
}

// Verify reCAPTCHA token
$recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
$recaptchaSecretKey = 'your_recaptcha_secret_key'; // Replace with your actual reCAPTCHA secret key
$recaptchaResponse = file_get_contents($recaptchaUrl . "?secret=" . $recaptchaSecretKey . "&response=" . $recaptchaToken);
$recaptchaData = json_decode($recaptchaResponse);

if (!$recaptchaData->success) {
    echo "reCAPTCHA verification failed.";
    exit;
}

// Save data to the database
$sql = "INSERT INTO users (first_name, last_name, dob, gender, telephone, email) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $firstName, $lastName, $dob, $gender, $telephone, $email);

if ($stmt->execute()) {
    echo "Data saved successfully!";
} else {
    echo "An error occurred while saving the data.";
}

$stmt->close();
$conn->close();
?>
