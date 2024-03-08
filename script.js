/*===== SEARCH BUTTON IN HOMEPAGE===== }*/
function showPatientInfoForm() {
    document.getElementById('newPatientForm').style.display = 'block';
    document.getElementById('homePage').style.display = 'none';
}

/*===== BACK BUTTON ===== */
document.getElementById('backHomepage').addEventListener('click', function() {
    var confirmation = confirm("Are you sure you want to leave? Any actions made will not be saved.");
    if (confirmation) {
        document.getElementById('newPatientForm').style.display = 'none';
        document.getElementById('homePage').style.display = 'block';
    }
});

/*===== SUBMIT BUTTON ===== */
$(document).on('click', '#confirmation', function() {
    const popup = document.querySelector('.popup');
    // Get values from input fields
    var First_Name = $("#First_Name").val();
    var Middle_Name = $("#Middle_Name").val();
    var Sur_Name = $("#Sur_Name").val();
    var Birthdate = $("#Birthdate").val();
    var Contact_Number = $("#Contact_Number").val();
    var Email = $("#Email").val();

    // Email validation
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(Email)) {
        $('#emailError').text('Please enter a valid email address.');
        return;
    } else {
        $('#emailError').text('');
    }

    if (!First_Name || !Middle_Name || !Sur_Name || !Birthdate || !Contact_Number || !Email) {
        alert('Please fill in all fields.');
        return;
    } else {
        popup.classList.add('active');
    }
});

/*===== POPUP Close button ===== */
$('#close-popup').on('click', function() {
    $('.popup').removeClass('active');
});

/*===== Check for special characters except ñ and é ===== */
function validateSpecialCharacters(input) {
    var regex = /^[a-zA-ZñÑéÉ\s]+$/;
    return regex.test(input);
}

/*===== Function to validate all fields before submission ===== */
function validateForm() {
    var First_Name = $("#First_Name").val();
    var Middle_Name = $("#Middle_Name").val();
    var Sur_Name = $("#Sur_Name").val();

    if (!validateSpecialCharacters(First_Name) || !validateSpecialCharacters(Middle_Name) || !validateSpecialCharacters(Sur_Name)) {
        alert('Fields cannot contain special characters except for ñ and é.');
        return false;
    }
    return true;
}

/*===== SUBMIT BUTTON IN newPatientForm ===== */
$(document).on('click','#submitBtn',function(){

    if (!validateForm()) {
        return;
    }

    var First_Name = $("#First_Name").val();
    var Middle_Name = $("#Middle_Name").val();
    var Sur_Name = $("#Sur_Name").val();
    var Birthdate = $("#Birthdate").val();
    var Contact_Number = $("#Contact_Number").val();
    var Email = $("#Email").val();
   
    
    $('.popup').removeClass('active');

    //alert("lalabas")
    $.ajax({ 
        type: 'post',
        url: 'insertRecord.php',
        data:{
            First_Name: First_Name,
            Middle_Name: Middle_Name,
            Sur_Name: Sur_Name,
            Birthdate: Birthdate,
            Contact_Number: Contact_Number,
            Email: Email
        },
        success: function(data){
            var response = JSON.parse(data);
            if (response.status === "success") {
                $('#myModal').modal('show');
                $('#modalPatientId').val(response.patientId);
                // Clear fields after submit
                $('#First_Name').val('');
                $('#Middle_Name').val('');
                $('#Sur_Name').val('');
                $('#Birthdate').val('');
                $('#Contact_Number').val('');
                $('#Email').val('');
            } else {
                if (response.message.includes("Multiple records found")) {
                    $('#myModal2').modal('show');
                } else if (response.message.includes("Duplicate record found")) {
                    $('#myModal1').modal('show');
                    $('#modalPatientId1').val(response.patientId);
                } else {
                    alert("Error: " + response.message);
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('An error occurred while processing the request.');
        }
    });
});

/*===== ContactNumber Validation ===== */
function validateContactNumber(input) {
    var contactNumber = input.value.replace(/\D/g, ''); // Remove non-digit characters
    if (contactNumber.length !== 11) {
        document.getElementById("error_message").innerText = "Please enter only numbers and enter exactly 11 digits.";
        input.setCustomValidity("Please enter only numbers and enter exactly 11 digits.");
    } else {
        document.getElementById("error_message").innerText = "";
        input.setCustomValidity("");
    }
}  