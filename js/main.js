jQuery(document).ready(function ($) {
  //cart count
  function updateCartCount() {
    $.ajax({
      url: ajax_params.ajax_url,
      type: "POST",
      data: {
        action: "update_cart_count",
      },
      success: function (response) {
        console.log(response);
        $(".my-cart-count").html(response);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error:", textStatus, errorThrown);
      },
    });
  }

  $(document.body).on(
    "added_to_cart removed_from_cart updated_wc_div wc_fragments_refreshed",
    function () {
      updateCartCount();
    }
  );

  // Initial cart count update
  updateCartCount();

  // scroll navbar

  // $(window).scroll(function () {
  //   var header = $("#header");
  //   var newHeight = header.height() + 100;
  //   var scrollTop = $(window).scrollTop();

  //   if (scrollTop > newHeight && !header.hasClass("fixed")) {
  //     header.addClass("fixed inset-0 z-[500] h-fit");
  //     $("#top-bar").removeClass("sm:block").addClass("sm:hidden");
  //     $(".headerLogo").height(38);
  //   } else if (scrollTop <= newHeight && header.hasClass("fixed")) {
  //     header.removeClass("fixed inset-0 z-[500] h-fit");
  //     $("#top-bar").addClass("sm:block").removeClass("sm:hidden");
  //     $(".headerLogo").height(56);
  //   }
  // });


  // toast of succesfully added to the cart
  $(document.body).on("added_to_cart", function () {
    $("#successToast").fadeIn();
    $("#successToastMessage").text(" Successfully added to Inquiry Cart!");

    setTimeout(function () {
      $("#successToast").fadeOut();
    }, 3000);
  });

  // send inquriy form
  $("#inquiryForm").submit(function (e) {
    e.preventDefault(); // Prevent form submission
    $("#send-inquiry-button").text("Sending ...").prop("disabled", true);
    $("#reset-inquiry-button").prop("disabled", true);

    // Serialize form data
    var formData = $(this).serialize();

    // Send AJAX request
    $.ajax({
      type: "POST",
      url: ajax_params.ajax_url,
      data: formData + "&action=submit_inquiry",
      success: function (response) {
        if (response.success) {
          $("#successToast").fadeIn();
          $("#successToastMessage").text(response.data);

          $("#inquiryForm")[0].reset();
          $("#send-inquiry-button").text("Send Inquiry").prop("disable", false);
          $("#reset-inquiry-button").prop("disabled", false);

          setTimeout(function () {
            $("#successToast").fadeOut();
          }, 3000);
        } else {
          $("#errorToast").fadeIn();
          $("#errorToastMessage").text(response.data);
          $("#send-inquiry-button").text("Send Inquiry").prop("disabled", false);
          $("#reset-inquiry-button").prop("disabled", false);
          setTimeout(function () {
            $("#errorToast").fadeOut();
          }, 3000);
        }
      },
      error: function (xhr, status, error) {
        console.error(error);
        var errorMessage = xhr.responseJSON.data;
        $("#errorToast").fadeIn();
        $("#errorToastMessage").text(errorMessage);
        $("#send-inquiry-button").text("Send Inquiry").prop("disabled", false);
        $("#reset-inquiry-button").prop("disabled", false);
        setTimeout(function () {
          $("#errorToast").fadeOut();
        }, 3000);
      },
    });
  });
});
