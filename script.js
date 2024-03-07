/*===== NEXT BUTTON IN HOMEPAGE===== }*/
function showPatientInfoForm() {
    document.getElementById('newPatientForm').style.display = 'block';
    document.getElementById('homePage').style.display = 'none';
}
/*===== BACK BUTTON IN HOMEPAGE FROM newPatientForm ===== */
document.getElementById('backHomepage').addEventListener('click', function() {
    var confirmation = confirm("Are you sure you want to leave? Any actions made will not be saved.");
    if (confirmation) {
        document.getElementById('newPatientForm').style.display = 'none';
        document.getElementById('homePage').style.display = 'block';
    }
});
$(document).on('click','#confirmation',function(){
    const popup = document.querySelector('.popup');
    popup.classList.add('active');
    //alert("lalabas")
});
/*===== SUBMIT BUTTON IN newPatientForm ===== */
$(document).on('click','#submitBtn',function(){
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

$('#close-popup').on('click', function() {
    $('.popup').removeClass('active');
});
/*===== ContactNumber Validation ===== */
function validateContactNumber(input) {
    var contactNumber = input.value.replace(/\D/g, ''); // Remove non-digit characters
    if (contactNumber.length !== 11) {
        document.getElementById("error_message").innerText = "Please enter only numbers.";
        input.setCustomValidity("Please enter only numbers.");
    } else {
        document.getElementById("error_message").innerText = "";
        input.setCustomValidity("");
    }
}  
