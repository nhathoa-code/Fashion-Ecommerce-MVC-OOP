async function showOrders(orders) {
  if (orders.length === 0) {
    $("#content").html(`<h5 style="margin-top:20px">Không có đơn hàng !</h5>`);
    return;
  }
  let output = "";
  for (let order of orders) {
    let subtotal = 0;
    output += `<table class="table">
                      <thead>
                          <tr>
                              <th style="width:6.5%;" scope="col"></th>
                              <th style="width: 30%;" scope="col"></th>
                              <th id="status" style="text-align: right;" scope="col">${order.status}</th>
                          </tr>
                      </thead>
                      <tbody>`;
    let res = await fetch(
      `http://localhost/ecommerce/business/api.php?action=order_detail&order_id=${order.id}`
    );
    let order_details = await res.json();
    for (let item of order_details) {
      subtotal += item.quantity * item.unit_price;
      output += `<tr>
                        <td>
                             <img style="width:100%;height:auto" src="${item.color.replace(
                               "/colors/",
                               "/color_images/"
                             )}" alt="">
                        </td>
                        <td>
                            ${item.name} <span style='color:red'> x </span> ${
        item.quantity
      }
                            <br>
                            Kích cỡ: ${item.size}
                            <br>
                            Màu sắc:
                            <img style="width:13px;height:auto;" src="${
                              item.color
                            }" alt="">
                        </td>
                        <td style="text-align:right">
                            ${number_format(item.unit_price)} đ
                            ${
                              Math.round(
                                (new Date().getTime() -
                                  new Date(order.shipped_on).getTime()) /
                                  (1000 * 3600 * 24)
                              ) <= 7
                                ? order.status === "Đã giao"
                                  ? `<br>
                            <button data-product-id=${
                              item.product_id
                            } class="btn btn-sm btn-primary ${
                                      item.reviewed ? "re_review" : "review"
                                    } mt-3">${
                                      item.reviewed
                                        ? "Đánh giá lại"
                                        : "Đánh giá"
                                    }</button>`
                                  : ""
                                : ""
                            }
                        </td>
                  </tr>`;
    }
    output += `<tr style="border-color:white">
                              <td>${
                                order.status === "Đang xử lý"
                                  ? `<button data-order-id=${order.id} class="btn btn-sm btn-danger cancel">Hủy</button>`
                                  : order.status === "Đã hủy"
                                  ? `<button data-order-id=${order.id} class="btn btn-sm btn-success reorder">Mua lại</button>`
                                  : ""
                              }</td>
                              <td></td>
                              <td style="width: 20%;text-align:right">Thành tiền: &nbsp;&nbsp;<span style="font-weight: bold;font-size:large">${number_format(
                                subtotal
                              )} đ</span></td>
                          </tr>
                      </tbody>
                      </table>`;
  }
  $("#content").html(output);
}

var Status = "";
$(".status-link li.nav-item").on("click", function () {
  Status = $(this).data("status");
  $(".status-link li.nav-item").css({
    textDecoration: "",
  });
  $(this).css({
    textDecoration: "underline",
    textUnderlineOffset: "8px",
  });
  fetch(
    `http://localhost/ecommerce/business/api.php?action=orders&status=${Status}`
  )
    .then((res) => res.json())
    .then(async (orders) => {
      showOrders(orders);
    });
});

function number_format(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

$("#tat_ca").click();

let $button;
$(document).on("click", "button.review", function () {
  $button = $(this);
  ProductId = parseInt($(this).data("product-id"));
  $("#exampleModal").modal("show");
  $("button[id=re_review]").attr("id", "review");
  $(".rate i").addClass("fa-star-o");
  $(".rate i").removeClass("fa-star");
  $("#name").val("");
  $("#review_content").val("");
});

$(document).on("click", "button.re_review", async function () {
  $button = $(this);
  ProductId = parseInt($(this).data("product-id"));
  let res = await fetch(
    `http://localhost/ecommerce/business/api.php?action=review_detail&product_id=${ProductId}`
  );
  let review = await res.json();
  $("#name").val(review.name);
  $("#review_content").val(review.content);
  Rate = review.rate;
  for (let i = 1; i <= review.rate; i++) {
    console.log(i);
    $(`.rate[data-rate=${i}] i`).removeClass("fa-star-o");
    $(`.rate[data-rate=${i}] i`).addClass("fa-star");
  }
  $("#exampleModal").modal("show");
  $("button[id=review]").attr("id", "re_review");
});

$(document).on("click", "#review", function () {
  $.ajax({
    url: "/ecommerce/business/review.php",
    type: "post",
    data: {
      action: "add_review",
      rate: Rate,
      product_id: ProductId,
      content: $("#review_content").val(),
    },
    success: function (response) {
      alert(response);
      $("#exampleModal").modal("hide");
      $(`button[data-product-id=${ProductId}]`).removeClass("review");
      $(`button[data-product-id=${ProductId}]`).addClass("re_review");
      $(`button[data-product-id=${ProductId}]`).text("Đánh giá lại");
    },
    error: function (error) {
      console.log(error);
    },
  });
});

$(document).on("click", "#re_review", function () {
  $.ajax({
    url: "/ecommerce/business/review.php",
    type: "post",
    data: {
      action: "update_review",
      rate: Rate,
      product_id: ProductId,
      name: $("#name").val(),
      content: $("#review_content").val(),
    },
    success: function (response) {
      alert(response);
      $("#exampleModal").modal("hide");
    },
    error: function (error) {
      console.log(error);
    },
  });
});

var Rate;
var ProductId;
$(".rate").on("click", function () {
  $(".rate i").addClass("fa-star-o");
  $(".rate i").removeClass("fa-star");
  Rate = parseInt($(this).data("rate"));
  for (let i = 1; i <= Rate; i++) {
    $(`.rate[data-rate=${i}] i`).removeClass("fa-star-o");
    $(`.rate[data-rate=${i}] i`).addClass("fa-star");
  }
});

$(document).on("click", "button.cancel", function () {
  let $button = $(this);
  let order_id = $button.data("order-id");
  $.ajax({
    url: "/ecommerce/business/order.php",
    type: "POST",
    data: {
      action: "cancel_order",
      order_id: order_id,
    },
    success: function (response) {
      alert(response);
      if (Status === "tất cả") {
        $button.text("Mua lại");
        $button.removeClass("cancel btn-danger");
        $button.addClass("reorder btn-success");
        $button
          .parent()
          .parent()
          .parent()
          .parent()
          .find("th#status")
          .text("Đã hủy");
      } else {
        $button.parent().parent().parent().parent().remove();
        if ($("#content").html() === "") {
          $("#content").html(
            `<h5 style="margin-top:20px">Không có đơn hàng !</h5>`
          );
        }
      }
    },
  });
});

$(document).on("click", "button.reorder", function () {
  let $button = $(this);
  let order_id = $button.data("order-id");
  $.ajax({
    url: "/ecommerce/business/order.php",
    type: "POST",
    data: {
      action: "re_order",
      order_id: order_id,
    },
    success: function (response) {
      alert(response);
      if (Status === "tất cả") {
        $button.text("Hủy");
        $button.removeClass("reorder btn-success");
        $button.addClass("cancel btn-danger");
        $button
          .parent()
          .parent()
          .parent()
          .parent()
          .find("th#status")
          .text("Đang xử lý");
      } else {
        $button.parent().parent().parent().parent().remove();
        if ($("#content").html() === "") {
          $("#content").html(
            `<h5 style="margin-top:20px">Không có đơn hàng !</h5>`
          );
        }
      }
    },
  });
});
