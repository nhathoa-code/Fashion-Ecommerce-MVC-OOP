const uploaded_images = [];
const removed_images = [];
const colors_uploaded = [];
const colors_removed = [];
const color_images = [];
const color_images_removed = [];
const colors_sizes = [];
const colors = [];
let sizes = [];

$.ajax({
  url: "business/size_type_value.php",
  method: "POST",
  data: {
    ajax_request: true,
    size_type_id: size_type_id,
  },
  success: function (response) {
    sizes = JSON.parse(response);
  },
  error: function (message) {
    console.log(message);
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

$(document).on("click", "li.color a.thumbnail", async function () {
  $("li.color a.thumbnail").css("borderColor", "");
  $(this).css("borderColor", "#337ab7");
  let image_name = $(this).data("name");
  let item = colors_sizes.find(function (value) {
    return value.image_name === image_name;
  });
  if (!item) {
    await $.ajax({
      url: "business/size_type_value.php",
      method: "POST",
      data: {
        get_color_sizes: true,
        product_id: product_id,
        image_color: image_name,
      },
      success: function (response) {
        let sizes = [];
        JSON.parse(response).forEach((item) => {
          sizes.push(item.size_id);
        });
        item = { image_name, sizes };
        colors_sizes.push(item);
      },
      error: function (error) {
        console.log(error);
      },
    });
  }
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

$("#form").on("submit", function (e) {
  e.preventDefault();
  $("#overlay").css("display", "block");
  let fd = new FormData(document.getElementById("form"));
  fd.append("ajax_request", true);
  fd.append("description", CKEDITOR.instances.description.getData());
  for (let i = 0; i < uploaded_images.length; i++) {
    fd.append("uploaded_images[]", uploaded_images[i]);
  }
  for (let i = 0; i < colors.length; i++) {
    fd.append("colors[]", colors[i]);
  }
  for (let i = 0; i < color_images.length; i++) {
    fd.append("color_images[]", color_images[i]);
  }
  if (colors_sizes.length > 0) {
    fd.append("colors_sizes", JSON.stringify(colors_sizes));
  }
  if (removed_images.length > 0) {
    fd.append("removed_images", removed_images);
  }
  if (colors_removed.length > 0) {
    fd.append("removed_colors", colors_removed);
  }
  if (color_images_removed.length > 0) {
    fd.append("removed_color_images", color_images_removed);
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
      console.log(error);
    },
  });
});

$(document).on("click", "i.uploaded-gallery", function () {
  let data_image = $(this).data("image");
  for (let i = 0; i < images.length; i++) {
    if (images[i].lastModified == data_image) {
      images.splice(i, 1);
    }
  }
  $(this).parent().remove();
});

$(".btn-del-old-img").on("click", function () {
  removed_images.push($(this).data("name"));
  $(this).parent().parent().parent().remove();
});

$(".btn-del-old-color-img").on("click", function () {
  color_images_removed.push($(this).data("name"));
  $(this).parent().parent().parent().remove();
});

$(".btn-del-old-color").on("click", function () {
  let color_name = $(this).data("name");
  if ($(".sizes input").data("name") === color_name) {
    $(".sizes .checkbox").remove();
  }
  colors_removed.push(color_name);
  $(this).parent().parent().parent().remove();
  for (let i = 0; i < colors_sizes.length; i++) {
    if (colors_sizes[i].image_name === color_name) {
      colors_sizes.splice(i, 1);
    }
  }
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
  $("div.sizes > div > div").html("");
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
