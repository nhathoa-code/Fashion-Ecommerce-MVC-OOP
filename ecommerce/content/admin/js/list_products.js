const table_content = $("table tbody").html();
$(".product-search-btn").on("click", function () {
  let keywords = $("input[name=keywords]").val();
  fetch(
    `/ecommerce/business/api.php?action=search_products&keywords=${keywords}`
  )
    .then((res) => res.json())
    .then((data) => {
      if (data.length === 0) {
        return alert("Không tìm thấy sản phẩm nào");
      }
      let output = "";
      data.forEach((product) => {
        console.log(product);
        output += `<tr>
                        <td>
                            <img src="http://localhost/ecommerce/content/images/${
                              product.dir
                            }/${product.image}" alt="">
                        </td>
                        <td>${product.name}</td>
                        <td>${number_format(product.price)} đ</td>
                        <td>${number_format(product.discounted_price)} đ</td>
                        <td>
                            <input class="btn btn-primary" type="submit" name="submit_edit_product_${
                              product.id
                            }" value="sữa">
                            <input class="btn btn-danger" type="submit" name="submit_delete_product_${
                              product.id
                            }" value="xóa">
                        </td>
                    </tr>`;
      });
      console.log(output);
      $(".add-product").replaceWith(
        `<button id="clear" class="btn btn-danger">Xóa kết quả tìm kiếm</button>`
      );
      $("table tbody").html(output);
    });
});

function number_format(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

$(document).on("click", "#clear", function () {
  $("table tbody").html(table_content);
  $("#clear").replaceWith(
    `<a href="?page=add_product_form" class="btn btn-primary add-product">Add new</a>`
  );
});
