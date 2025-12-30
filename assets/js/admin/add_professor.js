$(document).ready(function () {
  $("#addProfessorFormSubmit").click(function () {
    return addProfessorFormValidate();
  });
  function addProfessorFormValidate() {
    let firstNameError = false;
    let lastNameError = false;
    let emailError = false;
    let passwordError = false;
    let confirmPasswordError = false;

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

    function emailValidate() {
      var email = $("input[name='email']").val();
      var regexExp = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
      if (email == "") {
        $("#emailError").empty();
        $("#emailError").text("email is required.");
        emailError = true;
        return false;
      } else if (!email.match(regexExp)) {
        $("#emailError").empty();
        $("#emailError").text("email is invalid.");
        emailError = true;
        return false;
      } else if (emailExists(email)) {
        $("#emailError").empty();
        $("#emailError").text("sorry... email already taken.");
        emailError = true;
        return false;
      } else {
        $("#emailError").empty();
        emailError = false;
        return true;
      }
    }

    function passwordValidate() {
      var password = $("input[name='password']").val();
      if (password == "") {
        $("#passwordError").empty();
        $("#passwordError").text("password is required.");
        passwordError = true;
        return false;
      } else if (password.length < 8 || password.length > 10) {
        $("#passwordError").empty();
        $("#passwordError").text(
          "length of your password must be between 8 and 10."
        );
        passwordError = true;
        return false;
      } /*else if (!checkPasswordStrength(password)) {
        $("#passwordError").empty();
        $("#passwordError").text(
          "password should include alphabets, numbers, uppercase, lowercase and special characters."
        );
        passwordError = true;
        return false;
      }*/ else {
        $("#passwordError").empty();
        passwordError = false;
        return true;
      }
    }

    function confirmPasswordValidate() {
      var confirmPassword = $("input[name='confirmPassword']").val();
      var password = $("input[name='password']").val();
      if (confirmPassword != password) {
        $("#confirmPasswordError").empty();
        $("#confirmPasswordError").text("password didn't match.");
        confirmPasswordError = true;
        return false;
      } else {
        $("#confirmPasswordError").empty();
        confirmPasswordError = false;
        return true;
      }
    }

    firstNameValidate();
    lastNameValidate();
    emailValidate();
    passwordValidate();
    confirmPasswordValidate();

    if (
      !firstNameError &&
      !lastNameError &&
      !emailError &&
      !passwordError &&
      !confirmPasswordError
    ) {
      return true;
    } else {
      return false;
    }
  }

  function emailExists(email) {
    // var csrf_test_name = $("input[name=csrf_test_name]").val();
    var base_url = window.location.protocol + "//" + window.location.host;
    var pathname =
      "/student_grade_management_system/admin/admin_ajax_requests.php?q=EMAIL_EXISTS";
    var url = base_url.concat(pathname);
    data = {
      //   csrf_test_name: csrf_test_name,
      email: email,
    };
    var jqXHR = $.ajax({
      async: false,
      url: url,
      data: data,
      cache: false,
      method: "POST",
      dataType: "json",
      success: function (data) {
        // $("input[name='csrf_test_name']").val(data.csrf_test_name);
      },
    });
    return JSON.parse(jqXHR.responseText).response;
  }

  function checkPasswordStrength(password) {
    var number = /([0-9])/;
    var alphabets = /([a-zA-Z])/;
    var specialCharacters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
    if (
      password.match(number) &&
      password.match(alphabets) &&
      password.match(specialCharacters)
    ) {
      return true;
    }
    return false;
  }

});
