$(".update").on("click", function () {
  let status = $("#status").val();
  $.ajax({
    url: "/ecommerce/business/order.php",
    method: "post",
    data: {
      action: "update_status",
      order_id: order_id,
      status: status,
    },
    success: function (response) {
      alert(response);
      $("span.status").text(status);
    },
    error: function (error) {
      console.log(error);
    },
  });
});
