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
/*===== BACK BUTTON IN HOMEPAGE FROM existingPatientForm ===== 
document.getElementById('backHomepage_existing').addEventListener('click', function() {
    var confirmation = confirm("Are you sure you want to leave? Any actions made will not be saved.");
    if (confirmation) {
        document.getElementById('existingPatientForm').style.display = 'none';
        document.getElementById('homePage').style.display = 'block';
    }
});
$(document).on('click','#confirmation',function(){
    const popup = document.querySelector('.popup');
    popup.classList.add('active');
    //alert("lalabas")
    
});*/
/*===== SUBMIT BUTTON IN newPatientForm ===== */
$(document).on('click','#submitBtn',function(){
    var First_Name = $("#First_Name").val();
    var Middle_Name = $("#Middle_Name").val();
    var Sur_Name = $("#Sur_Name").val();
    var Birthdate = $("#Birthdate").val();
    var Contact_Number = $("#Contact_Number").val();
    var Email = $("#Email").val();
    var patientId = $(this).data('id');
    
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
/*===== SEARCH BUTTON IN newPatientForm ===== 
$(document).ready(function() {
    $('#searchButton').click(function() {
        var searchTerm = $('#searchInput').val();

        $.ajax({
            type: 'post',
            url: 'search.php',
            data: {
                search: searchTerm
            },
            success: function(data) {
                $('#searchResults').html(data);
            }
        });
    });
});*/

/*===== EDIT/OPEN MODAL BUTTON IN existingPatientForm =====
$(document).ready(function() {
    $(document).on('click', '.editBtn', function() {
        var patientId = $(this).data('id');

        $('#myModal').modal('show');

        $.ajax({
            url: 'selectData.php',
            type: 'post',
            data: { 
                Patient_ID: patientId
             },
            success: function(response) {
                console.log('Response:', response);
                $('#modalPatientId').val(response.Patient_ID);
                $('#modalFirstName').val(response.FirstName);
                $('#modalMiddleName').val(response.MiddleName);
                $('#modalSurName').val(response.SurName);
                $('#modalBirthdate').val(response.Birthdate);
                $('#modalContactNumber').val(response.ContactNumber);
                $('#modalEmail').val(response.Email);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching patient details:', error);
            }
        });
    });
}); */
/*===== CLOSE MODAL BUTTON IN existingPatientForm ===== 
$(document).ready(function() {
    $(document).on('click', '.close', function() {
        $('#myModal').modal('hide');
    });
});*/
/*===== EDIT/UPDATE BUTTON IN existingPatientForm ===== 
$(document).on('click', '#updateBtn', function() {
    var patientId = $('#modalPatientId').val();
    //alert(patientId);
    var formData = {
        Patient_ID: $('#modalPatientId').val(),
        modalFirstName: $('#modalFirstName').val(),
        modalMiddleName: $('#modalMiddleName').val(),
        modalSurName: $('#modalSurName').val(),
        modalBirthdate: $('#modalBirthdate').val(),
        modalContactNumber: $('#modalContactNumber').val(),
        modalEmail: $('#modalEmail').val()
    };

    $.ajax({
        url: 'updateData.php',
        type: 'post',
        data: formData,
        success: function(response) {
            alert('Data updated successfully');
        },
        error: function(xhr, status, error) {
            console.error('Error updating data:', error);
        }
    });
});

$('#myModal').on('shown.bs.modal', function () {
    $('.modal-backdrop').remove();
});*/

/*  SAMPLE API
$.ajax({
    url: 'https://randomuser.me/api/',
    dataType: 'json',
    success: function(data) {
        console.log(data);
    }
});
*/