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

    if ( !validateSpecialCharacters(First_Name) || !validateSpecialCharacters(Middle_Name) || !validateSpecialCharacters(Sur_Name)) {
        alert('Fields cannot contain special characters except for ñ and é.');
        return false;
    }
    return true;
}

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

/*===== SUBMIT BUTTON IN newPatientForm ===== */
$(document).on('click', '#submitBtn', function() {
  if (!validateForm()) {
      return;
  }

  var formData = {
      First_Name: $("#First_Name").val(),
      Middle_Name: $("#Middle_Name").val(),
      Sur_Name: $("#Sur_Name").val(),
      Mobile_Phone_No: $("#Contact_Number").val(),
      eMail: $("#Email").val(),
  };

  $('.popup').removeClass('active');

  $.ajax({
      type: 'get',
      url: 'api_get.php',
      data: formData,
      dataType: 'json',
      beforeSend: function(){
        // Show image container
        $("#loader").show();
       },
      success: function(response) {
          console.log(response);
          if (response.hasOwnProperty('status')) {
              if (response.status === "exists") {
                  const recordCount = response.hasOwnProperty('recordCount') ? response.recordCount : 0;
                  if (recordCount > 1) {
                      $('#myModal2').modal('show');
                      // Clear fields
                      $('#First_Name').val('');
                      $('#Middle_Name').val('');
                      $('#Sur_Name').val('');
                      $('#Birthdate').val('');
                      $('#Contact_Number').val('');
                      $('#Email').val('');
                  } else {
                      $('#myModal1').modal('show');
                      $('#modalPatientId1').val(response.patientId);
                      $('#First_Name').val('');
                      $('#Middle_Name').val('');
                      $('#Sur_Name').val('');
                      $('#Birthdate').val('');
                      $('#Contact_Number').val('');
                      $('#Email').val('');
                  }
              } else if (response.status === "not_exists") {
                  /*===== POST API **********  ===== */
                  $.ajax({
                      type: 'post',
                      url: 'api_post.php',
                      data: formData,
                      dataType: 'json',
                      beforeSend: function(){
                        // Show image container
                        $("#loader").show();
                       },
                      success: function(response) {
                          console.log(response);
                          $('#myModal').modal('show');
                          $('#modalPatientId').val(response.accountNo);
                          $('#First_Name').val('');
                          $('#Middle_Name').val('');
                          $('#Sur_Name').val('');
                          $('#Birthdate').val('');
                          $('#Contact_Number').val('');
                          $('#Email').val('');
                      },
                      error: function(xhr, status, error) {
                          console.error('Error:', error);
                          $('#myModal3').modal('show');
                      },
                      complete: function() {
                        $("#loader").hide();
                      }
                  });
              }
          } else {
              alert("Unexpected response format.");
          }
      },
      error: function(xhr, status, error) {
          console.error('Error:', error);
          $('#myModal3').modal('show');
      },
      complete: function() {
          $("#loader").hide(); 
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