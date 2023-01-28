let container_height = $(".shop-category-menu .container").height();
let container_top = $(".shop-category-menu .container").offset().top;
$(".shop-category-menu").css("height", container_height);

$(window).scroll(function (event) {
  var scroll = $(window).scrollTop();
  if (scroll >= container_top) {
    $(".shop-category-menu .container").css({
      position: "fixed",
      top: "0",
      left: "50%",
      transform: "translateX(-50%)",
      zIndex: "999",
      backgroundColor: "white",
    });
  } else {
    $(".shop-category-menu .container").css({
      position: "",
      top: "",
      left: "",
      transform: "",
      zIndex: "",
      backgroundColor: "",
    });
  }
});
