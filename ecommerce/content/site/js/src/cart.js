import Shopping_Cart from "./cartClass.js";

const ShoppingCart = new Shopping_Cart(items);

/*----------------------------
 Cart Plus Minus Button
------------------------------ */
$("input[name=qtybutton]").keypress(function (evt) {
  evt.preventDefault();
});
$(".cart-plus-minus").prepend('<div class="dec qtybutton">-</div>');
$(".cart-plus-minus").append('<div class="inc qtybutton">+</div>');
$(".qtybutton").on("click", function () {
  var $button = $(this);
  var id = $button.parent().parent().parent().data("id");
  var oldValue = $button.parent().find("input").val();
  if ($button.text() == "+") {
    var newVal = parseInt(oldValue) + 1;
  } else {
    // Don't allow decrementing below zero
    if (oldValue > 1) {
      var newVal = parseInt(oldValue) - 1;
    } else {
      newVal = 1;
    }
  }
  $.ajax({
    url: "/ecommerce/business/shopping_cart.php",
    type: "post",
    data: {
      action: "update_item_quantity",
      id: id,
      quantity: parseInt(newVal),
    },
    success: function () {
      ShoppingCart.updateItem(id, newVal);
      $(".cart-subtotal").text(
        number_format(ShoppingCart.getSubtotal()) + " đ"
      );
      $(".order-subtotal strong").text(
        number_format(ShoppingCart.getSubtotal() + 0) + " đ"
      );
      let unit_price = ShoppingCart.getItemById(id).unit_price;
      $(`.cart-table .total-${id}`).text(
        number_format(newVal * unit_price) + " đ"
      );
      $(".cart-brief").text(number_format(ShoppingCart.getSubtotal()) + " đ");
      $(".cart-icon sup").text(
        ShoppingCart.countItems() >= 10
          ? ShoppingCart.countItems()
          : "0" + ShoppingCart.countItems()
      );
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
                                                    <h4><a href="#">${
                                                      item.name
                                                    }</a></h4>
                                                    <span>${
                                                      item.unit_price
                                                    } x ${
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
      $(".mini-cart-body").html(output);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(textStatus, errorThrown);
    },
  });
  $button.parent().find("input").val(newVal);
});

$(document).on("click", ".remove a", function () {
  let $button = $(this);
  let id = $button.parent().parent().data("id");
  $.ajax({
    url: "/ecommerce/business/shopping_cart.php",
    type: "post",
    data: {
      action: "delete_cart_item",
      id: id,
    },
    success: function (response) {
      $button.parent().parent().remove();
      alert(response);
      ShoppingCart.deleteItem(id);
      $(".cart-subtotal").text(
        number_format(ShoppingCart.getSubtotal()) + " đ"
      );
      $(".order-subtotal").text(
        number_format(ShoppingCart.getSubtotal() + 0) + " đ"
      );
      $(".cart-brief").text(number_format(ShoppingCart.getSubtotal()) + " đ");
      $(".cart-icon sup").text(
        ShoppingCart.countItems() >= 10
          ? ShoppingCart.countItems()
          : "0" + ShoppingCart.countItems()
      );
      let items = ShoppingCart.getItems();
      if (items.length === 0) {
        $(".mini-cart-body").html(`<h3>Không có sản phẩm trong giỏ hàng!</h3>`);
        $(".cart-inner-bottom").remove();
        $(".cart-container").html(`<h1>Không có sản phẩm trong giỏ hàng!</h1>`);
      } else {
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
                                                  <h4><a href="#">${
                                                    item.name
                                                  }</a></h4>
                                                  <span>${item.unit_price} x ${
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
        $(".mini-cart-body").html(output);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(textStatus, errorThrown);
    },
  });
});

$(document).on("click", ".pro-del", function () {
  let id = $(this).data("id");
  ShoppingCart.deleteItem(id);
  $(`.cart-table tbody tr[data-id=${id}]`).remove();
});

function number_format(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
