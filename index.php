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
            <img src="img/hobli.png" /> <br>
            <p> <?php
                date_default_timezone_set("Asia/Manila");
                echo "Date and Time <br> " . date("m/d/Y  h:i:sa");
            ?> </p>
             <h1>Welcome to Vision Express</h1>
        </div>
        <div>
          <button class="btn btn-primary" onclick="showPatientInfoForm()">Let us Begin!</button>
        </div>
    </div>
    <!-- PATIENT REGISTRATION FORM -->
    <div class="container h-100" id="newPatientForm" style="display:none;">
    <div id="infoHeader" >
            <img src="img/hobli.png" /><br>
            <p> <?php
                date_default_timezone_set("Asia/Manila");
                echo "Date and Time <br> " . date("m/d/Y  h:i:sa");
            ?> </p>
        </div>
        <div class="card">
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
                    <input type="text" id="Contact_Number" name="Contact_Number" class="form-control form-control-lg" placeholder="Your contact number.." maxlength="11" oninput="validateContactNumber(this)" pattern="[0-9]{11}" title="Please enter exactly 11 digits." required>
                    <span id="error_message" style="color: red;font-size:12px;position:absolute;"></span>
                </div>
                <div class="form-outline mb-4">
                    <label for="email">Email:</label><br>
                    <input type="email" id="Email" name="Email" class="form-control form-control-lg" placeholder="Your email.." required>
                    <span class="error" id="emailError" style="color: red; font-size: 12px;"></span>
                </div>
                <div class="d-flex justify-content-center mb-2">
                    <button type="submit" class="btn btn-danger btn-block btn-lg" id="confirmation">Submit</button>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-dark btn-block btn-lg gradient-custom-4" id="backHomepage">Back</button>
                </div>
            </div>
        </div>
    </div>
    <!--  MODAL NEW RECORD  -->
    <div class="modal" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="successModal">
                <div class="modal-header">
                    <div class="title-container" >
                        <h5 class="modal-title">Successfully created your record!</h5>
                    </div>
                    <di class="btn-container">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </di>
                </div>
                    <p style="text-align:center;">Thank you for choosing Vision Express!</p>
                    <p style="text-align:center;">Here's your patient ID<input type="text" id="modalPatientId" name="modalPatientId" disabled><br></p>
            </div>
        </div>
    </div>
    <!--  MODAL ONE RECORD  -->
    <div class="modal" id="myModal1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="existingModal">
                <div class="modal-header">
                    <div class="title-container" >
                        <h5 class="modal-title">You have an existing record!</h5>
                    </div>
                    <di class="btn-container">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </di>
                </div>
                    <p style="text-align:center;">Thank you for choosing Vision Express!</p>
                    <p style="text-align:center;">Here's your patient ID<input type="text" id="modalPatientId1" name="modalPatientId" disabled><br></p>
            </div>
        </div>
    </div>
    <!--  MODAL MULTIPLE RECORD  -->
    <div class="modal" id="myModal2" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="multiModal">
                <div class="modal-header">
                    <div class="title-container" >
                        <img src="img/warning.png" style="width:50px;margin-top:-15px;"/>
                        <h5 class="modal-title">Further assistance needed!</h5>
                    </div>
                    <di class="btn-container">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </di>
                </div>
                    <p style="text-align:center;">Please approach our Store Personal for assistance.</p>
            </div>
        </div>
    </div>
        <!--  MODAL FOR UNABLE TO COMMUNICATE TO API   -->
    <div class="modal" id="myModal3" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <img src="img/warning.png" style="width:50px;margin-top:-15px;"/>
                    <p style="text-align:center;">Our apologies that we are unable to process your request at the moment. <br>
                    Please contact Store Personnel for futher assistance.
                </p>
            </div>
        </div>
    </div>
    <!--  POPUP MESSAGE  -->
    <div class="popup">
        <div class="popup-container">
            <p>Do you want to submit your record?</p>
            <button type="button" class="btn btn-primary" id="submitBtn">Yes</button>
            <button type="button" class="btn btn-secondary" id="close-popup">No</button>
        </div>
    </div>

    <div id='loader'>
      <img src='img/loader.gif'> <b>Loading..</b>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>