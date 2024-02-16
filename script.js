/*===== NEXT BUTTON IN HOMEPAGE===== */
function showPatientInfoForm() {
    var isNewPatientChecked = document.getElementById('new-patient').checked;
    var isExistingPatientChecked = document.getElementById('existing-patient').checked;

    if (isNewPatientChecked) {
        document.getElementById('newPatientForm').style.display = 'block';
        document.getElementById('existingPatientForm').style.display = 'none';
        document.getElementById('homePage').style.display = 'none';
    } else if (isExistingPatientChecked) {
        document.getElementById('newPatientForm').style.display = 'none';
        document.getElementById('existingPatientForm').style.display = 'block';
        document.getElementById('homePage').style.display = 'none';
    } else {
        alert('Please select at least one option.');
    }
}
/*===== BACK BUTTON IN HOMEPAGE FROM newPatientForm ===== */
document.getElementById('backHomepage').addEventListener('click', function() {
    var confirmation = confirm("Are you sure you want to leave? Any actions made will not be saved.");
    if (confirmation) {
        document.getElementById('newPatientForm').style.display = 'none';
        document.getElementById('existingPatientForm').style.display = 'none';
        document.getElementById('homePage').style.display = 'block';
    }
});
/*===== BACK BUTTON IN HOMEPAGE FROM existingPatientForm ===== */
document.getElementById('backHomepage_existing').addEventListener('click', function() {
    var confirmation = confirm("Are you sure you want to leave? Any actions made will not be saved.");
    if (confirmation) {
        document.getElementById('existingPatientForm').style.display = 'none';
        document.getElementById('homePage').style.display = 'block';
    }
});

/*===== SUBMIT BUTTON IN newPatientForm ===== */
$(document).on('click','#submitBtn',function(){
    var First_Name = $("#First_Name").val();
	var Middle_Name = $("#Middle_Name").val();
    var Sur_Name = $("#Sur_Name").val();
	var Birthdate = $("#Birthdate").val();
    var Contact_Number = $("#Contact_Number").val();
	var Email = $("#Email").val();
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
        success: function( data ){
            var response = JSON.parse(data);
            if (response.status === "success") {
                alert("Successfully Added!");
            } else {
                if (response.message.includes("already exists")) {
                    alert("The data you input is already exists in the database.");
                } else {
                    alert("Error: " + response.message);
                }
            }
        }
    })
});
/*===== SEARCH BUTTON IN newPatientForm ===== */
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
});

/*  SAMPLE API
$.ajax({
    url: 'https://randomuser.me/api/',
    dataType: 'json',
    success: function(data) {
        console.log(data);
    }
});
*/