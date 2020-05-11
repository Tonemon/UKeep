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

// Right click support for dashboard

$('.right-click-support-dashboard').on('contextmenu', function(e) {
  $("#context-menu-dashboard").css({
    display: "block",
    top: e.clientY - 40,
    left: e.clientX
  }).addClass("show");
  return false; // blocks default Webbrowser right click menu
}).on("click", function() {
  $("#context-menu-dashboard").removeClass("show").hide();
});

$("#context-menu-dashboard a").on("click", function() {
  $(this).parent().removeClass("show").hide(); // hides menu after clicking inside it
});

$("body").on("click", function() {
  $("#context-menu-dashboard").removeClass("show").hide();// hides menu after clicking anywhere
});



// Right click support for sidebar

$('.right-click-support-sidebar').on('contextmenu', function(e) {
  $("#context-menu-sidebar").css({
    display: "block",
    top: e.clientY -40,
    left: e.clientX
  }).addClass("show");
  return false; // blocks default Webbrowser right click menu
}).on("click", function() {
  $("#context-menu-sidebar").removeClass("show").hide();
});

$("#context-menu-sidebar a").on("click", function() {
  $(this).parent().removeClass("show").hide(); // hides menu after clicking inside it
});

$("body").on("click", function() {
  $("#context-menu-sidebar").removeClass("show").hide();// hides menu after clicking anywhere
});