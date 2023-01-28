$("button[type=submit]").on("click", function (e) {
  e.preventDefault();
  $(".error").remove();
  $.ajax({
    url: "/ecommerce/business/account.php",
    type: "post",
    data: {
      submit_change_pass_0: true,
      old_pass: $("#old_pass").val(),
      new_pass: $("#new_pass").val(),
      re_new_pass: $("#re_new_pass").val(),
    },
    success: function (response) {
      let res = JSON.parse(response);
      if (res.hasOwnProperty("error_old_pass")) {
        if (!$("#error_old_pass").length) {
          $("#old_pass").after(
            `<div id="error_old_pass" class="alert alert-danger error" role="alert">${res.error_old_pass}</div>`
          );
        }
        return;
      } else {
        $("#error_old_pass").remove();
      }
      if (res.hasOwnProperty("error_new_pass")) {
        if (!$("#error_new_pass").length) {
          $("#new_pass").after(
            `<div id="error_new_pass" class="alert alert-danger error" role="alert">Mật khẩu mới không được để trống</div>`
          );
          return;
        }
      } else {
        $("error_new_pass").remove();
      }
      if (res.hasOwnProperty("error_re_new_pass")) {
        if (!$("#error_old_pass").length) {
          $("#re_new_pass").after(
            `<div id="error_old_pass" class="alert alert-danger error" role="alert">${res.error_re_new_pass}</div>`
          );
          return;
        }
      } else {
        $("#error_old_pass").remove();
      }
      if (res.hasOwnProperty("success")) {
        alert("Đổi mật khẩu thành công");
        $("#old_pass").val("");
        $("#new_pass").val("");
        $("#re_new_pass").val("");
      }
    },
    error: function (message) {
      console.log(message);
    },
  });
});
