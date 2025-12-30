$(document).ready(function () {
    $("#loginFormSubmit").click(function () {
        return loginFormValidate();
      });
      function loginFormValidate() {
        let usernameError = false;
        let passwordError = false;
    
        function usernameValidate() {
          var username = $("input[name='username']").val();
          if (username == '') {
            $("#usernameError").empty();
            $("#usernameError").text("username is required.");
            usernameError = true;
            return false;
          } else {
            $("#usernameError").empty();
            usernameError = false;
            return true;
          }
        }
    
        function passwordValidate() {
          var password = $("input[name='password']").val();
          if (password == '') {
            $("#passwordError").empty();
            $("#passwordError").text("password is required.");
            passwordError = true;
            return false;
          } else {
            $("#passwordError").empty();
            passwordError = false;
            return true;
          }
        }
    
        passwordValidate();
        usernameValidate();
    
        if (!usernameError &&
          !passwordError) {
          return true;
        } else {
          return false;
        }
      }
});