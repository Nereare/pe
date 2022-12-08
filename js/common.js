$(function() {
  console.log("Page ready!");

  // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
  $(".navbar-burger").on("click", function() {
    $(".navbar-burger").toggleClass("is-active");
    $(".navbar-menu").toggleClass("is-active");
  });

  // Show login form
  $("#show-login-form").on("click", function() {
    $("#login-modal").addClass("is-active");
  });
  // Cancel login form
  $("#login-cancel").on("click", function() {
    $("#login-modal").removeClass("is-active");
    $("#login-username, #login-password").val("");
  });
  // Do login
  $("#login-login").on("click", function() {
    //
  });

  //
});
