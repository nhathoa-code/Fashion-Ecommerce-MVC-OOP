let address;
let data;
let districts;
fetch("http://localhost/ecommerce/business/api.php?action=profile_detail")
  .then((res) => res.json())
  .then((data) => {
    if (data && data.save_to_deli_info === 1) {
      $("input[name=ho_ten]").val(data.fullname);
      $("input[name=email]").val(data.email);
      $("input[name=sdt]").val(data.phone);
      address = JSON.parse(data.address);
      $("input[name=dia_chi]").val(address.dia_chi);
    } else {
      $("input[name=ho_ten]").val("");
      $("input[name=email]").val("");
      $("input[name=sdt]").val("");
      address = JSON.parse("{}");
      $("input[name=dia_chi]").val("");
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
        $("select[name=tinh_thanh]").html(tinh_thanh_output);
        districts = province.districts;
        let quan_huyen_output =
          "<option disabled selected value=''>Chọn Quận/Huyện</option>";
        districts.forEach((item) => {
          quan_huyen_output += `<option data-code=${item.code} ${
            item.name === address.quan_huyen ? "selected" : ""
          } value="${item.name}">${item.name}</option>`;
        });
        $("select[name=quan_huyen]").html(quan_huyen_output);
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
        $("select[name=phuong_xa]").html(phuong_xa_output);
      });

    $("select[name=tinh_thanh]").on("change", function () {
      $("#ward").html("");
      let code = parseInt($("option:selected", this).data("code"));
      districts = data.find((item) => item.code === code).districts;
      let quan_huyen_output =
        "<option disabled selected value=''>Chọn Quận/Huyện</option>";
      districts.forEach((item) => {
        quan_huyen_output += `<option data-code=${item.code} value="${item.name}">${item.name}</option>`;
      });
      $("select[name=quan_huyen]").html(quan_huyen_output);
    });

    $("select[name=quan_huyen]").on("change", function () {
      let code = parseInt($("option:selected", this).data("code"));
      let wards = districts.find((item) => item.code === code).wards;
      let phuong_xa_output =
        "<option disabled selected value=''>Chọn Phường/Xã</option>";
      wards.forEach((item) => {
        phuong_xa_output += `<option value="${item.name}">${item.name}</option>`;
      });
      $("select[name=phuong_xa]").html(phuong_xa_output);
    });
  });
