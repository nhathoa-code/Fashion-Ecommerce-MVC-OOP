var imagesPreview = function (input, placeToInsertImagePreview) {
  if (input.files) {
    var filesAmount = input.files.length;
    for (i = 0; i < filesAmount; i++) {
      var reader = new FileReader();
      reader.onload = function (event) {
        $(`${placeToInsertImagePreview} img`).remove();
        $(
          $.parseHTML(
            `<img style="width:100%;height:auto" src="${event.target.result}" alt="fakeimg">`
          )
        ).appendTo(placeToInsertImagePreview);
      };
      reader.readAsDataURL(input.files[i]);
    }
  }
};

$("input[name=image]").on("change", function () {
  imagesPreview(this, "div#preview");
});

$(document).on("click", "#add_slider_btn", function () {
  let fd = new FormData(document.getElementById("form"));
  fd.append("action", "add_slider");
  $.ajax({
    url: "/ecommerce/business/slider.php",
    method: "post",
    data: fd,
    contentType: false,
    processData: false,
    success: function (response) {
      alert(JSON.parse(response).message);
      let image_name = $("input[name=image]").prop("files")[0].name;
      $("table tbody").append(`<tr id=${JSON.parse(response).id}>
                    <td class="hidden-xs hidden-sm image">
                        <img style="width:100%;height:auto" src="http://localhost/ecommerce/content/images/slider/${image_name}" alt="">
                    </td>
                    <td class="title">${$("input[name=title]").val()}</td>
                    <td class="title1">${$("input[name=title1]").val()}</td>
                    <td class="content">${$(
                      "textarea[name=content]"
                    ).val()}</td>
                    <td class="button">${$("input[name=button]").val()}</td>d
                    <td class="link">${$("input[name=link]").val()}</td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button data-id=${
                              JSON.parse(response).id
                            } data-image=${image_name} class="btn btn-success edit">Sữa</button>
                            <button data-id=${
                              JSON.parse(response).id
                            } data-image=${image_name} class="btn btn-danger delete">Xóa</button>
                        </div>
                    </td>
                </tr>`);
      $("#form")[0].reset();
      $("textarea").val("");
      $("div#preview img").remove();
    },
    error: function (error) {
      console.log(error);
    },
  });
});

let id, old_image;
$(document).on("click", ".edit", function () {
  id = $(this).data("id");
  old_image = $(this).data("image");
  let tr_row = $(`tr#${id}`);
  let title = tr_row.find(".title").text();
  let title1 = tr_row.find(".title1").text();
  let content = tr_row.find(".content").text();
  let button = tr_row.find(".button").text();
  let link = tr_row.find(".link").text();
  image = $(this).data("image");
  $("input[name=title]").val(title);
  $("input[name=title1]").val(title1);
  $("textarea[name=content]").val(content);
  $("input[name=button]").val(button);
  $("input[name=link]").val(link);
  $("div#preview img").remove();
  $("div#preview").append(
    `<img style="width:100%;height:auto" src="http://localhost/ecommerce/content/images/slider/${image}" alt="fakeimg">`
  );
  $("input#add_slider_btn").before(
    `<input id="update_slider_btn" type="submit" class="btn btn-success" value="Câp nhật">`
  );
  $("input#add_slider_btn").remove();
  if (!$("#cancel").length) {
    $("input#update_slider_btn").after(
      `<input id="cancel" type="submit" class="btn btn-danger" value="Bỏ" style="margin-left:3px">`
    );
  }
});

$(document).on("click", "#update_slider_btn", function () {
  let fd = new FormData(document.getElementById("form"));
  fd.append("id", id);
  fd.append("old_image", old_image);
  fd.append("action", "update_slider");
  $.ajax({
    url: "/ecommerce/business/slider.php",
    method: "post",
    data: fd,
    contentType: false,
    processData: false,
    success: function (response) {
      alert(JSON.parse(response).message);
      let tr_row = $(`tr#${id}`);
      tr_row.find(".title").text($("input[name=title]").val());
      tr_row.find(".title1").text($("input[name=title1]").val());
      tr_row.find(".content").text($("textarea[name=content]").val());
      tr_row.find(".button").text($("input[name=button]").val());
      tr_row.find(".link").text($("input[name=link]").val());
      if (JSON.parse(response).image) {
        tr_row
          .find(".image img")
          .attr(
            "src",
            `http://localhost/ecommerce/content/images/slider/${image}`
          );
      }
      $("#form")[0].reset();
      $("textarea").val("");
      $("div#preview img").remove();
    },
    error: function (error) {
      console.log(error);
    },
  });
});

$(document).on("click", ".delete", function () {
  let $button = $(this);
  let id = $button.data("id");
  let image = $button.data("image");
  $.ajax({
    url: "/ecommerce/business/slider.php",
    method: "post",
    data: {
      action: "delete_slider",
      id: id,
      image: image,
    },
    success: function (response) {
      alert(response);
      $button.parent().parent().parent().remove();
    },
    error: function (error) {
      console.log(error);
    },
  });
});

$(document).on("click", "#cancel", function () {
  $("input#update_slider_btn").before(
    `<input id="add_slider_btn" type="submit" class="btn btn-success" value="Thêm">`
  );
  $("input#update_slider_btn").remove();
  $(this).remove();
  $("#form")[0].reset();
  $("textarea").val("");
  $("div#preview img").remove();
});
