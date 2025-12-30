$(document).ready(function () {
    $("#editProfessorFormSubmit").click(function () {
      return editProfessorFormValidate();
    });
    function editProfessorFormValidate() {
      let firstNameError = false;
      let lastNameError = false;
  
      function firstNameValidate() {
        var firstName = $("input[name='firstName']").val();
        if (firstName == "") {
          $("#firstNameError").empty();
          $("#firstNameError").text("first name is required.");
          firstNameError = true;
          return false;
        } else {
          $("#firstNameError").empty();
          firstNameError = false;
          return true;
        }
      }
  
      function lastNameValidate() {
        var lastName = $("input[name='lastName']").val();
        if (lastName == "") {
          $("#lastNameError").empty();
          $("#lastNameError").text("last name is required.");
          lastNameError = true;
          return false;
        } else {
          $("#lastNameError").empty();
          lastNameError = false;
          return true;
        }
      }
  
      firstNameValidate();
      lastNameValidate();
      
  
      if (!firstNameError && !lastNameError) {
        return true;
      } else {
        return false;
      }
    }
  });
  