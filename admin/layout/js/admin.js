$(document).ready(function() {
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
  // convert password feild to text feild on eye hover
  var pass = $(".password");
  $(".show-pass").hover(
    function() {
      pass.attr("type", "text");
    },
    function() {
      pass.attr("type", "password");
    }
  );
  // confirmation message on delete
  $(".confirm").click(function() {
    return confirm("Are you sure? ");
  });
  // category veiw option
  $(".cat h4").click(function() {
    $(this)
      .next(".full-veiw")
      .fadeToggle(500);
  });
  $(".options span").click(function() {
    $(this)
      .addClass("active")
      .siblings("span")
      .removeClass("active");
    if ($(this).data("view") === "full") {
      $(".cat .full-veiw").fadeIn(200);
    } else {
      $(".cat .full-veiw").fadeOut(200);
    }
  });
});
