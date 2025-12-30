$(document).ready(function () {
  $("#submitGradeAppealFormSubmit").click(function () {
    return submitGradeAppealFormValidate();
  });
  function submitGradeAppealFormValidate() {
    let titleError = false;
    let descriptionError = false;

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

    titleValidate();
    descriptionValidate();

    if (!titleError && !descriptionError) {
      return true;
    } else {
      return false;
    }
  }
});
