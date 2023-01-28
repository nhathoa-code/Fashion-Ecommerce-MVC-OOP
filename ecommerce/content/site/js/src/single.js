import Shopping_Cart from "./cartClass.js";

if (typeof items !== "undefined") {
  var ShoppingCart = new Shopping_Cart(items);
}

const colors_sizes = [];
var color;
var size;

$("a.cart").on("click", function () {
  if (!color || !size) {
    return alert("Vui lòng chọn kích cỡ và màu sắc !");
  }
  let item_info = {
    product_id: product_id,
    quantity: isNaN(parseInt($("input[type=number]").val()))
      ? 1
      : parseInt($("input[type=number]").val()),
    unit_price: unit_price,
    size: size,
    color: color,
  };
  $.ajax({
    url: "/ecommerce/business/shopping_cart.php",
    type: "post",
    data: {
      action: "add_cart_item",
      item_info: item_info,
    },
    success: function (response) {
      if (response === "not signed in") {
        window.location.href = "/ecommerce/sign-in";
      } else {
        alert(JSON.parse(response).message);
        item_info["id"] = parseInt(JSON.parse(response).id);
        ShoppingCart.addToCart(item_info);
        $(".cart-brief").text(number_format(ShoppingCart.getSubtotal()) + " đ");
        $(".cart-icon sup").text(ShoppingCart.countItems());
        let items = ShoppingCart.getItems();
        let output = "";
        items.forEach((item) => {
          output += `<div class="cart-img-details">
                                              <div class="cart-img-photo">
                                                  <a href="#"><img src="${item.color.replace(
                                                    /\/colors\//,
                                                    "/color_images/"
                                                  )}"></a>
                                              </div>
                                              <div class="cart-img-content">
                                                  <h4><a href="#">${product_name}</a></h4>
                                                  <span>${number_format(
                                                    item.unit_price
                                                  )} x ${
            item.quantity
          } (size: ${item.size})</span>
                                              </div>
                                              <div class="pro-del" data-id="${parseInt(
                                                item.id
                                              )}">
                                                  <a href="javascript:void(0)"><i class="pe-7s-trash"></i></a>
                                              </div>
                                          </div>`;
        });
        if (!$(".cart-inner-bottom").length) {
          $(".mini-cart-body").after(`<div class="cart-inner-bottom">
                                          <a href="/ecommerce/shopping-cart" class="cart-button-top cart-left">xem giỏ hàng</a>
                                          <a href="/ecommerce/checkout" class="cart-button-top">thanh toán</a>
                                      </div>`);
        }
        $(".mini-cart-body").html(output);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(textStatus, errorThrown);
    },
  });
});

$(document).on("click", ".size ul li", function () {
  $(".size ul li").removeClass("active");
  $(this).addClass("active");
  size = $(this).children().text();
});

$(".qty input").keypress(function (evt) {
  evt.preventDefault();
});

function number_format(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

$("a.color").on("click", async function () {
  $("a.color").css({ border: "", padding: "" });
  $(this).css({ border: "1px solid red", padding: "3px" });
  color = $(this).css("backgroundImage").slice(4, -1).replace(/"/g, "");
  size = null;
  let image_name = $(this).data("img-color");
  let item = colors_sizes.find(function (value) {
    return value.image_name === image_name;
  });
  if (!item) {
    await $.ajax({
      url: "/ecommerce/business/size_type_value.php",
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
    output += `<li style="${
      !item.sizes.includes(size.id) ? "opacity:0.5;pointer-events:none" : ""
    }"><a href='javascript:void(0)'>${size.size}</a></li>`;
  });
  $(".size ul").html(output);

  /*--------------------
  ---------------------*/
  let image_url = $(this)
    .css("backgroundImage")
    .replace(/url|\(|\)|"/g, "");
  image_url = image_url.replace("/colors/", "/color_images/");
  if ($(`img[data-image="${image_name}"]`).length) {
    $(`img[data-image="${image_name}"]`).click();
    return;
  }
  $(".large-product-tab-menu").html(carousel_html.replace("active", ""));
  $(".simpleLens-container").html(simpleLens_container.replace("active", ""));
  $(
    ".single-product-view .large-product-tab-menu .product-details-carousel"
  ).prepend(`<div role="presentation" class="active">
                <a href="#img-color" role="tab" data-toggle="tab">
                    <img src="${image_url}" alt="" />
                </a>
              </div>`);
  $(`img[src="${image_url}"]`).css({
    border: "2px solid #32c4d1",
    paddingLeft: "0",
    paddingRight: "0",
  });
  $(
    ".single-product-view .view-large-photo .simpleLens-container"
  ).prepend(`<div role="tabpanel" class="tab-pane active" id="img-color">
                <div class="simpleLens-big-image-container">
                    <a class="simpleLens-lens-image" data-lens-image="${image_url}" href="#">
                        <img src="${image_url}" alt="" class="simpleLens-big-image" />
                    </a>
                </div>
            </div>`);

  $(".product-details-carousel").owlCarousel({
    autoPlay: false,
    slideSpeed: 2000,
    pagination: false,
    navigation: true,
    items: 4,
    navigationText: [
      "<i class='pe-7s-preview'></i>",
      "<i class='pe-7s-play'></i>",
    ],
    itemsDesktop: [1199, 4],
    itemsDesktopSmall: [980, 4],
    itemsTablet: [768, 4],
    itemsMobile: [479, 2],
  });

  $(".simpleLens-lens-image").simpleLens({
    loading_image: image_url,
  });
});

$(document).on("click", ".owl-item img", function (e) {
  e.preventDefault();
  $(".owl-item img").css({
    border: "",
    padding: "",
  });
  $(this).css({
    border: "2px solid #32c4d1",
    paddingLeft: "0",
    paddingRight: "0",
  });
});
