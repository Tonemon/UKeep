// Right click support for items

$('.right-click-support-items').on('contextmenu', function(e) {
  $("#context-menu").css({
    display: "block",
    top: e.clientY - 210,
    left: e.clientX - 120
  }).addClass("show");
  return false; // blocks default Webbrowser right click menu
}).on("click", function() {
  $("#context-menu").removeClass("show").hide();
});

$("#context-menu a").on("click", function() {
  $(this).parent().removeClass("show").hide(); // hides menu after clicking inside it
});

$("body").on("click", function() {
  $("#context-menu").removeClass("show").hide();// hides menu after clicking anywhere
});