/* ------------------------------------------------------------------------------
 *
 *  # Custom JS code
 *
 *  Place here all your custom js. Make sure it's loaded after app.js
 *
 * ---------------------------------------------------------------------------- */

function saveFirstName(first_name, employeeId){
    var first_name = document.getElementById(first_name).value;

    console.log(first_name);

    jQuery.ajax({
        type: "POST",
        url: "/admin/employees/update-employee-first-name",
        data: {employeeId:employeeId, first_name:first_name, _token: token},
        success: function(data) {
        },

    });
}

function saveMiddleName(middle_name, employeeId){
    var middle_name = document.getElementById(middle_name).value;

    jQuery.ajax({
        type: "POST",
        url: "/admin/employees/update-employee-middle-name",
        data: {employeeId:employeeId, middle_name:middle_name, _token: token},
        success: function(data) {
        },

    });
}

function saveLastName(last_name, employeeId){
    var last_name = document.getElementById(last_name).value;

    jQuery.ajax({
        type: "POST",
        url: "/admin/employees/update-employee-last-name",
        data: {employeeId:employeeId, last_name:last_name, _token: token},
        success: function(data) {
        },

    });
}

function saveDob(dob, employeeId){
    var dob = document.getElementById(dob).value;

    jQuery.ajax({
        type: "POST",
        url: "/admin/employees/update-employee-dob",
        data: {employeeId:employeeId, dob:dob, _token: token},
        success: function(data) {
        },

    });
}

function saveMaritalStatus(marital_status, employeeId){
    var marital_status = document.getElementById(marital_status).value;

    jQuery.ajax({
        type: "POST",
        url: "/admin/employees/update-employee-marital-status",
        data: {employeeId:employeeId, marital_status:marital_status, _token: token},
        success: function(data) {
        },

    });
}

function saveGender(gender, employeeId){
    var gender = document.getElementById(gender).value;

    jQuery.ajax({
        type: "POST",
        url: "/admin/employees/update-employee-gender",
        data: {employeeId:employeeId, gender:gender, _token: token},
        success: function(data) {
        },

    });
}

function saveNationality(nationality, employeeId){
    var nationality = document.getElementById(nationality).value;

    console.log(nationality);

    jQuery.ajax({
        type: "POST",
        url: "/admin/employees/update-employee-nationality",
        data: {employeeId:employeeId, nationality:nationality, _token: token},
        success: function(data) {
        },

    });
}

function saveOfficeNumber(office_number, employeeId){
    var office_number = document.getElementById(office_number).value;

    jQuery.ajax({
        type: "POST",
        url: "/admin/employees/update-employee-office-number",
        data: {employeeId:employeeId, office_number:office_number, _token: token},
        success: function(data) {
        },

    });
}

function saveEmail(email, employeeId){
    var email = document.getElementById(email).value;

    jQuery.ajax({
        type: "POST",
        url: "/admin/employees/update-employee-email",
        data: {employeeId:employeeId, email:email, _token: token},
        success: function(data) {
        },

    });
}

function saveMobileNumber(mobile_number, employeeId){
    var mobile_number = document.getElementById(mobile_number).value;

    jQuery.ajax({
        type: "POST",
        url: "/admin/employees/update-mobile-number",
        data: {employeeId:employeeId, mobile_number:mobile_number, _token: token},
        success: function(data) {
        },

    });
}

function savePersonalEmail(personal_email, employeeId){
    var personal_email = document.getElementById(personal_email).value;

    jQuery.ajax({
        type: "POST",
        url: "/admin/employees/update-personal-email",
        data: {employeeId:employeeId, personal_email:personal_email, _token: token},
        success: function(data) {
        },

    });
}

function saveNin(nin, employeeId){
    var personal_email = document.getElementById(personal_email).value;

    jQuery.ajax({
        type: "POST",
        url: "/admin/employees/update-personal-email",
        data: {employeeId:employeeId, personal_email:personal_email, _token: token},
        success: function(data) {
        },

    });
}
