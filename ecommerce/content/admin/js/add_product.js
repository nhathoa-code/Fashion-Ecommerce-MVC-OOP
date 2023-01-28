const uploaded_images = [];
let sizes = [];
const colors = [];
const color_images = [];
const colors_sizes = [];

$("#form").validate({
  rules: {
    name: "required",
    price: "required",
    ["categories" + "[]"]: "required",
    image: "required",
    size_type: "required",
  },
  messages: {
    name: {
      required: "Bạn chưa nhập tên sản phẩm !",
    },
    price: {
      required: "Bạn chưa nhập giá sản phẩm !",
    },
    ["categories" + "[]"]: {
      required: "Bạn chưa chọn danh mục sản phẩm !",
    },
    image: {
      required: "Bạn chưa tải ảnh sản phẩm !",
    },
    size_type: {
      required: "Bạn chưa chọn loại kích cỡ sản phẩm !",
    },
  },
  errorPlacement: function (error, element) {
    if (element.context.name === "categories[]") {
      error.appendTo($("#product_category"));
    } else if (element.context.name === "size_type") {
      error.appendTo($("#size_types > div"));
    } else {
      error.insertAfter(element);
    }
  },
  submitHandler: function (form) {
    $("#overlay").css("display", "block");
    let fd = new FormData(document.getElementById("form"));
    fd.append("ajax_request", true);
    fd.append("submit_add_product_0", "");
    fd.append("description", CKEDITOR.instances.description.getData());
    fd.append("colors_sizes", JSON.stringify(colors_sizes));
    for (let i = 0; i < uploaded_images.length; i++) {
      fd.append("gallery[]", uploaded_images[i]);
    }
    for (let i = 0; i < colors.length; i++) {
      fd.append("colors[]", colors[i]);
    }
    for (let i = 0; i < color_images.length; i++) {
      fd.append("color_images[]", color_images[i]);
    }
    $.ajax({
      url: "business/product.php",
      method: "POST",
      data: fd,
      contentType: false,
      processData: false,
      success: function (response) {
        alert(response);
        location.reload();
      },
      error: function (error) {
        alert(error);
      },
    });
  },
});

var imagesPreview = function (input, placeToInsertImagePreview) {
  if (input.files) {
    var filesAmount = input.files.length;

    for (i = 0; i < filesAmount; i++) {
      if (placeToInsertImagePreview === "ul.colors") {
        colors.push(input.files[i]);
        colors_sizes.push({ image_name: input.files[i].name, sizes: [] });
      } else if (placeToInsertImagePreview === "ul.color_images") {
        color_images.push(input.files[i]);
      } else {
        uploaded_images.push(input.files[i]);
      }
      var reader = new FileReader();
      let data_image = input.files[i].lastModified;
      let image_name = input.files[i].name;
      reader.onload = function (event) {
        $(
          $.parseHTML(
            `<li ${
              placeToInsertImagePreview === "ul.colors" ? "class=color" : null
            }>
            <div class="thumbnails-options" style="display: none;">
                <div class="btn-group">
                    <div data-name=${image_name} data-image="${data_image}" class="${
              placeToInsertImagePreview === "ul.colors"
                ? "btn-del-color"
                : placeToInsertImagePreview === "ul.color_images"
                ? "btn-del-color-img"
                : "btn-del-img"
            } btn btn-sm btn-danger"><i class="fa fa-times"></i></div>
                </div>
            </div>
            <a href="javascript:void(0)" data-name=${image_name} class="thumbnail"><img src="${
              event.target.result
            }" alt="fakeimg"></a>
        </li>`
          )
        ).appendTo(placeToInsertImagePreview);
      };
      reader.readAsDataURL(input.files[i]);
    }
  }
};

$("#gallery").on("change", function () {
  imagesPreview(this, "ul.gallery");
});

$("#colors").on("change", function () {
  imagesPreview(this, "ul.colors");
});

$("#color_images").on("change", function () {
  imagesPreview(this, "ul.color_images");
});

$("#image").on("change", function () {
  var reader = new FileReader();
  reader.onload = function (event) {
    $(".image").html(
      `<li><a href="javascript:void(0)" class="thumbnail"><img src="${event.target.result}" alt="fakeimg" class="img-rounded"></a></li>`
    );
  };
  reader.readAsDataURL(this.files[0]);
});

$(document).on("click", ".btn-del-img", function (e) {
  let data_image = $(this).data("image");
  for (let i = 0; i < uploaded_images.length; i++) {
    if (uploaded_images[i].lastModified == data_image) {
      uploaded_images.splice(i, 1);
      break;
    }
  }
  $(this).parent().parent().parent().remove();
  if (uploaded_images.length === 0) {
    $("#gallery").val("");
  }
});

$(document).on("click", ".btn-del-color", function (e) {
  let data_image = $(this).data("image");
  let data_name = $(this).data("name");
  if ($(".sizes input").data("name") === data_name) {
    $(".sizes .checkbox").remove();
  }
  for (let i = 0; i < colors.length; i++) {
    if (colors[i].lastModified == data_image) {
      colors.splice(i, 1);
      colors_sizes.splice(i, 1);
      break;
    }
  }
  $(this).parent().parent().parent().remove();
  if (colors.length === 0) {
    $("#colors").val("");
  }
});

$(document).on("click", ".btn-del-color-img", function (e) {
  let data_image = $(this).data("image");
  for (let i = 0; i < color_images.length; i++) {
    if (color_images[i].lastModified == data_image) {
      color_images.splice(i, 1);
      break;
    }
  }
  $(this).parent().parent().parent().remove();
  if (color_images.length === 0) {
    $("#gallery").val("");
  }
});

$(document).on("click", "li.color a.thumbnail", function () {
  let size_types = $("input[name=size_type]").toArray();
  let ischecked = false;
  for (let i = 0; i < size_types.length; i++) {
    if (size_types[i].checked) {
      ischecked = true;
      break;
    }
  }
  if (!ischecked) {
    return alert("Bạn chưa chọn loại kích cỡ !");
  }
  $("li.color a.thumbnail").css("borderColor", "");
  $(this).css("borderColor", "#337ab7");
  let image_name = $(this).data("name");
  let item = colors_sizes.find(function (value) {
    return value.image_name === image_name;
  });
  let output = "";
  sizes.forEach(function (size, index) {
    output += `<div class="checkbox">
                  <label for="example-checkbox${size.id}">
                    <input type="checkbox" ${
                      item.sizes.includes(size.id) ? "checked" : ""
                    } data-name=${image_name} id="example-checkbox${
      size.id
    }" value="${size.id}"> ${size.value}
                  </label>
                </div>`;
  });
  $("div.sizes > div > div").html(output);
});

$(document).on("change", ".sizes input", function () {
  let image_name = $(this).data("name");
  let size_id = Number($(this).val());
  let item = colors_sizes.find(function (value) {
    return value.image_name === image_name;
  });
  if ($(this).is(":checked")) {
    item.sizes.push(size_id);
  } else {
    let position = item.sizes.indexOf(size_id);
    item.sizes.splice(position, 1);
  }
});

$(document).on("change", "input[name=size_type]", function () {
  $.ajax({
    url: "business/size_type_value.php",
    method: "POST",
    data: {
      ajax_request: true,
      size_type_id: $(this).val(),
    },
    success: function (response) {
      sizes = JSON.parse(response);
    },
    error: function (err) {
      console.log(err);
    },
  });
});
