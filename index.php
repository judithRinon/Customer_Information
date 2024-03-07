<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Information Web Application</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- CSS -->
	<link rel="stylesheet" href="style.css">
</head> 
<body> 
    <!-- HOMEPAGE -->
    <div class="container" id="homePage">
        <div id="header">
            <img src="img/hobli.png" />
            <h1>Welcome to HOBLI</h1>
            <p> <?php
                date_default_timezone_set("Asia/Manila");
                echo "Date and Time <br> " . date("m/d/Y  h:i:sa");
            ?> </p>
        </div>
        <div>
          <p>Let us Begin!</p>
          <button class="btn btn-primary" onclick="showPatientInfoForm()">Search</button>
        </div>
        <!-- <div class="row justify-content-center">
            <div class="col-md-6">
                <p>Let us Begin!</p>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="patient-type" id="new-patient">
                    <label class="form-check-label" for="new-patient">New Patient</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="patient-type" id="existing-patient">
                    <label class="form-check-label" for="existing-patient">Existing Patient</label>
                </div>
                <br><br>
                <button class="btn btn-primary" onclick="showPatientInfoForm()">Next</button>
            </div>
        </div>-->
    </div>
    <!-- NEW PATIENT REGISTRATION -->
    <div class="container h-100" id="newPatientForm" style="display:none;">
    <div id="header">
            <img src="img/hobli.png" />
            <h1>Patient Information</h1>
            <p> <?php
                date_default_timezone_set("Asia/Manila");
                echo "Date and Time <br> " . date("m/d/Y  h:i:sa");
            ?> </p>
        </div>
        <div class="card" style="border-radius: 15px;margin-top: 20px;width:30rem;">
            <div class="card-body">
              <h2 class="text-uppercase text-center mb-5">Patient Information Form</h2>
                <div class="form-outline mb-4">
                  <label for="First_Name">First Name:</label><br>
                  <input type="text" id="First_Name" name="First_Name" class="form-control form-control-lg" placeholder="Your First name.." required>
                </div>
                <div class="form-outline mb-4">
                  <label for="Middle_Name">Middle Name:</label><br>
                  <input type="text" id="Middle_Name" name="Middle_Name" class="form-control form-control-lg" placeholder="Your Middle name.." required>
                </div>
                <div class="form-outline mb-4">
                    <label for="Sur_Name">Last Name:</label><br>
                    <input type="text" id="Sur_Name" name="Sur_Name" class="form-control form-control-lg" placeholder="Your Last name.." required>
                </div>
                <div class="form-outline mb-4">
                    <label for="Birthdate">Birthdate:</label><br>
                    <input type="date" id="Birthdate" name="Birthdate" class="form-control form-control-lg" required>
                </div>
                <div class="form-outline mb-4">
                    <label for="Contact_Number">Contact Number:</label><br>
                    <input type="tel" id="Contact_Number" name="Contact_Number" class="form-control form-control-lg" placeholder="Your contact number.." maxlength="11" oninput="validateContactNumber(this)" pattern="[0-9]{11}" title="Please enter exactly 11 digits." required>
                    <span id="error_message" style="color: red;font-size:12px;position:absolute;"></span>
                </div>
                <div class="form-outline mb-4">
                    <label for="email">Email:</label><br>
                    <input type="email" id="Email" name="Email" class="form-control form-control-lg" placeholder="Your email.." required>
                </div>
                <div class="d-flex justify-content-center">
                  <button type="button"
                    class="btn btn-success btn-block btn-lg gradient-custom-4 text-body" id="confirmation">Submit</button>
                </div>
               <div class="d-flex justify-content-center">
                    <button type="button"
                    class="btn btn-secondary btn-block btn-lg gradient-custom-4 text-body" id="backHomepage">Back</button>
                </div>
            </div>
        </div>
    </div>
    <!-- EXISTING PATIENT 
    <div class="container" id="existingPatientForm" style="display: none;">
        <h2 class="text-uppercase text-center mb-5" style="margin-top:20px;">Exiting Patient Information Form</h2>
        <div>
            <div class="card-body row no-gutters align-items-center">
                <div class="col">
                    <input name="search" id="searchInput" class="form-control form-control-lg form-control-borderless" type="search" placeholder="Search topics or keywords">
                </div>
                <div class="col-auto">
                    <button class="btn btn-lg btn-success" id="searchButton" type="submit">Search</button>
                </div>
            </div>
            <div id="searchResults"></div>
            <button class="btn btn-secondary" id="backHomepage_existing">Back</button>
        </div>
    </div> -->
    <!--  MODAL NEW RECORD  -->
    <div class="modal" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Welcome to Vision Express</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <h2 style="text-align:center;">We are unable to locate your record</h2>
                    <p style="text-align:center;">we create a new record for you</p>
                    <p style="text-align:center;">Your Patient ID is:<input type="text" id="modalPatientId" name="modalPatientId" disabled><br></p>
            </div>
        </div>
    </div>
    <!--  MODAL ONE RECORD  -->
    <div class="modal" id="myModal1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Woah. You have an existing record!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <p style="text-align:center;">Thank you for being a loyal customer/patient of Vision Express</p>
                    <p style="text-align:center;">Here is your Patient ID for reference:<input type="text" id="modalPatientId1" name="modalPatientId" disabled><br></p>
            </div>
        </div>
    </div>
    <!--  MODAL MULTIPLE RECORD  -->
    <div class="modal" id="myModal2" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <p style="text-align:center;">Please contact Store Personnel for further assistance</p>
            </div>
        </div>
    </div>
<div class="popup">
  <div class="popup-container">
    <p>Do you want to submit your record?</p>
    <button type="button" class="btn btn-primary" id="submitBtn">Yes</button>
    <button type="button" class="btn btn-secondary" id="close-popup">No</button>
  </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>