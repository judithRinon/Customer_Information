<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Information Web Application</title>
    <!-- CSS -->
	<link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container" id="homePage">
        <h1>Welcome to HOBLI</h1>
        <p>Please select one of the options below:</p>
        <label for="new-patient">New Patient:</label>
        <input type="radio" id="new-patient" name="patient-type">
        <label for="existing-patient">Existing Patient:</label>
        <input type="radio" id="existing-patient" name="patient-type">
        <br><br>
        <button class="btn" onclick="showPatientInfoForm()">Next</button>
    </div>
    <div class="container" id="newPatientForm" style="display: none;">
        <h2>Patient Information Form</h2>
        <div>
            <label for="First_Name">First Name:</label><br>
            <input type="text" id="First_Name" name="First_Name"><br>
            <label for="Middle_Name">Middle Name:</label><br>
            <input type="text" id="Middle_Name" name="Middle_Name"><br>
            <label for="Sur_Name">SurName:</label><br>
            <input type="text" id="Sur_Name" name="Sur_Name"><br>
            <label for="Birthdate">Birthdate:</label><br>
            <input type="date" id="Birthdate" name="Birthdate"><br>
            <label for="Contact_Number">Contact Number:</label><br>
            <input type="tel" id="Contact_Number" name="Contact_Number" pattern="[0-9]*" title="Please enter a valid 11-digit number" required><br>
            <label for="email">Email:</label><br>
            <input type="email" id="Email" name="Email"><br><br>
            <button class="btn" id="backHomepage">Back</button>
            <button class="btn" id="submitBtn" >Submit</button>
        </div>
    </div>
    <div class="container" id="existingPatientForm" style="display: none;">
        <h2>Exiting Patient Information Form</h2>
        <div>
            <div class="search-container">
                <input type="text" name="search" id="searchInput">
                <button id="searchButton">Search</button>
            </div>
            <div id="searchResults"></div>
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name"><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email"><br><br>
            <button class="btn" id="backHomepage_existing">Back</button>
            <button class="btn">Edit</button>
            <button type="submit" class="btn">Submit</button>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</body>
</html>