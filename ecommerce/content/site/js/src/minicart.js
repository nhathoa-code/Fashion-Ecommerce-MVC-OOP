import Shopping_Cart from "./cartClass.js";

const ShoppingCart = new Shopping_Cart(items);

$(document).on("click", ".pro-del", function () {
  let pro_del_btn = $(this);
  $.ajax({
    url: "/ecommerce/business/shopping_cart.php",
    type: "post",
    data: {
      action: "delete_cart_item",
      id: pro_del_btn.data("id"),
    },
    success: function (response) {
      pro_del_btn.parent().remove();
      alert(response);
      let id = pro_del_btn.data("id");
      ShoppingCart.deleteItem(id);
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
        let str = window.location.pathname;
        let pos = str.lastIndexOf("/");
        let result = str.substring(pos + 1);
        if (result === "shopping-cart") {
          $(".cart-container").html(
            `<h1>Không có sản phẩm trong giỏ hàng!</h1>`
          );
        }
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

function number_format(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
