$(document).ready(function () {
  $("#grade").keydown(function (e) {
    onlyNumber(e);
  });
  $("#editGradeFormSubmit").click(function () {
    return editGradeFormValidate();
  });
  function editGradeFormValidate() {
    let gradeError = false;

    function gradeValidate() {
      var grade = $("input[name='grade']").val();
      if (grade == "") {
        $("#gradeError").empty();
        $("#gradeError").text("grade is required.");
        gradeError = true;
        return false;
      } else if (grade < 0 || grade > 100) {
        $("#gradeError").empty();
        $("#gradeError").text("grade must be from 0 to 100.");
        gradeError = true;
        return false;
      } else {
        $("#gradeError").empty();
        gradeError = false;
        return true;
      }
    }

    gradeValidate();

    if (!gradeError) {
      return true;
    } else {
      return false;
    }
  }
});
