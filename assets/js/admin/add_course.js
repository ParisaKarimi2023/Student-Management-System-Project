$(document).ready(function () {
  $("#addCourseFormSubmit").click(function () {
    return addCourseFormValidate();
  });
  function addCourseFormValidate() {
    let titleError = false;
    let descriptionError = false;
    let professorError = false;

    function titleValidate() {
      var title = $("input[name='title']").val();
      if (title == "") {
        $("#titleError").empty();
        $("#titleError").text("title is required.");
        titleError = true;
        return false;
      } else {
        $("#titleError").empty();
        titleError = false;
        return true;
      }
    }

    function descriptionValidate() {
      var description = $("textarea[name='description']").val();
      if (description == "") {
        $("#descriptionError").empty();
        $("#descriptionError").text("description is required.");
        descriptionError = true;
        return false;
      } else {
        $("#descriptionError").empty();
        descriptionError = false;
        return true;
      }
    }

    function professorValidate() {
      var professor = $("select[name='professor']").val();
      if (professor == "") {
        $("#professorError").empty();
        $("#professorError").text("professor is required.");
        professorError = true;
        return false;
      } else {
        $("#professorError").empty();
        professorError = false;
        return true;
      }
    }

    titleValidate();
    descriptionValidate();
    professorValidate();

    if (!titleError && !descriptionError && !professorError) {
      return true;
    } else {
      return false;
    }
  }
});
