$(document).ready(function() {
  // Switch between login &signup page

  $(".login-page h1 span").click(function() {
    $(this).addClass("selected").siblings().removeClass("selected");
    $(".login-page form").hide();
    $("." + $(this).data("class")).fadeIn(200);
  });

  // Trigger the select box it
  $("select").selectBoxIt({
    autoWidth: false
  });
  // Hide placeholder on foucs

  $("[placeholder]")
    .focus(function() {
      $(this).attr("data-text", $(this).attr("placeholder"));
      $(this).attr("placeholder", "");
    })
    .blur(function() {
      $(this).attr("placeholder", $(this).attr("data-text"));
    });

  // add astrisk for required feilds
  $("input").each(function() {
    if ($(this).attr("required") === "required") {
      $(this).after('<span class="astrisk"> * </span>');
    }
  });

  // confirmation message on delete
  $(".confirm").click(function() {
    return confirm("Are you sure? ");
  });

});