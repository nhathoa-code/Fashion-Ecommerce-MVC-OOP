const orders = $("table tbody").html();
console.log(orders);

$(".search").on("click", function () {
  let order_id = $("input[name=OrderId]").val();
  fetch(
    `/ecommerce/business/api.php?action=search_order_by_id&order_id=${order_id}`
  )
    .then((res) => res.json())
    .then((order) => {
      if (!order) {
        alert("Không có đơn hàng nào");
        return;
      }
      if ($("table").length) {
        $("table tbody").html(`<tr>
                                <td class="text-center"><input type="checkbox" name="check1-td1"></td>
                                <td class="hidden-xs hidden-sm">${order.id}</td>
                                <td>${order.status}</td>
                                <td>${order.created_on}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="?page=order_detail&order_id=${order.id}" class="btn btn-xs btn-success">Chi tiết</a>
                                    </div>
                                </td>
                            </tr>`);
      } else {
        $("h1").remove();
        $("#status_menu").after(` <table class="table">
            <thead>
                <tr>
                    <th class="cell-small text-center" data-toggle="tooltip" title="" data-original-title="Toggle all!"><input type="checkbox" id="check1-all" name="check1-all"></th>
                    <th class="hidden-xs hidden-sm">Mã đơn hàng</th>
                    <th class="hidden-xs hidden-sm">Trạng thái</th>
                    <th class="hidden-xs hidden-sm">Ngày Tạo</th>
                    <th class="text-center"><i class="fa fa-bolt"></i> Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center"><input type="checkbox" name="check1-td1"></td>
                    <td class="hidden-xs hidden-sm">${order.id}</td>
                    <td>${order.status}</td>
                    <td>${order.created_on}</td>
                    <td class="text-center">
                        <div class="btn-group">
                            <a href="?page=order_detail&order_id=${order.id}" class="btn btn-xs btn-success">Chi tiết</a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>`);
      }
    });
});
