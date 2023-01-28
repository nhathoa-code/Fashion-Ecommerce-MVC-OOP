let address;
let data;
let districts;
fetch("http://localhost/ecommerce/business/api.php?action=profile_detail")
  .then((res) => res.json())
  .then((data) => {
    if (data) {
      if (data.save_to_deli_info === 1) {
        $("#save_to_deli_info").prop("checked", true);
      }
      $("#username").val(data.username);
      $("#fullname").val(data.fullname);
      $("#email").val(data.email);
      $("#phone").val(data.phone);
      address = JSON.parse(data.address);
      $("#address").val(address.dia_chi);
    } else {
      $("#username").val("");
      $("#fullname").val("");
      $("#email").val("");
      $("#phone").val("");
      address = JSON.parse("{}");
      $("#address").val("");
    }
    fetch("https://provinces.open-api.vn/api/?depth=3")
      .then((res) => res.json())
      .then((result) => {
        data = result;
        let province = data.find((item) => item.name === address.tinh_thanh);
        let tinh_thanh_output =
          "<option disabled selected value=''>Chọn Tỉnh/Thành</option>";
        data.forEach((item) => {
          tinh_thanh_output += `<option data-code=${item.code} ${
            item.name === address.tinh_thanh ? "selected" : ""
          } value="${item.name}">${item.name}</option>`;
        });
        $("#province").html(tinh_thanh_output);
        districts = province.districts;
        let quan_huyen_output =
          "<option disabled selected value=''>Chọn Quận/Huyện</option>";
        districts.forEach((item) => {
          quan_huyen_output += `<option data-code=${item.code} ${
            item.name === address.quan_huyen ? "selected" : ""
          } value="${item.name}">${item.name}</option>`;
        });
        $("#district").html(quan_huyen_output);
        let wards = districts.find(
          (item) => item.name === address.quan_huyen
        ).wards;
        let phuong_xa_output =
          "<option disabled selected value=''>Chọn Phường/Xã</option>";
        wards.forEach((item) => {
          phuong_xa_output += `<option value="${item.name}" ${
            item.name === address.phuong_xa ? "selected" : ""
          }>${item.name}</option>`;
        });
        $("#ward").html(phuong_xa_output);
      });

    $("#province").on("change", function () {
      $("#ward").html("");
      let code = parseInt($("option:selected", this).data("code"));
      districts = data.find((item) => item.code === code).districts;
      let quan_huyen_output =
        "<option disabled selected value=''>Chọn Quận/Huyện</option>";
      districts.forEach((item) => {
        quan_huyen_output += `<option data-code=${item.code} value="${item.name}">${item.name}</option>`;
      });
      $("#district").html(quan_huyen_output);
    });

    $("#district").on("change", function () {
      let code = parseInt($("option:selected", this).data("code"));
      let wards = districts.find((item) => item.code === code).wards;
      let phuong_xa_output =
        "<option disabled selected value=''>Chọn Phường/Xã</option>";
      wards.forEach((item) => {
        phuong_xa_output += `<option value="${item.name}">${item.name}</option>`;
      });
      $("#ward").html(phuong_xa_output);
    });
  });

$("button[type=submit]").on("click", function (e) {
  e.preventDefault();
  let address = {
    dia_chi: $("#address").val(),
    phuong_xa: $("#ward").val(),
    quan_huyen: $("#district").val(),
    tinh_thanh: $("#province").val(),
  };
  $.ajax({
    url: "http://localhost/ecommerce/business/account.php",
    type: "post",
    data: {
      submit_update_profile_0: true,
      username: $("#username").val(),
      fullname: $("#fullname").val(),
      email: $("#email").val(),
      phone: $("#phone").val(),
      save_to_deli_info: $("#save_to_deli_info").is(":checked") ? true : null,
      address: JSON.stringify(address),
    },
    success: function (response) {
      alert(response);
    },
    error: function (message) {
      console.log(message);
    },
  });
});
