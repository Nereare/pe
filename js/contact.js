$(function() {
  console.log("Contact page ready!");

  // Start MDE
  simplemde_config["element"] = $("#contact-body")[0];
  let simplemde = new SimpleMDE(simplemde_config);

  // Send message
  $("#contact-send").on("click", function() {
    $(this)
      .attr("disabled", true)
      .addClass("is-loading");
    if ($("#contact-recaptcha-key").val() != "") {
      if ($("#contact-from-email").val() != "" && simplemde.value() != "") {
        // First, contact reCAPTCHA
        let recaptcha_key = $("#contact-recaptcha-key").val();
        grecaptcha.ready(function () {
          grecaptcha
            .execute(recaptcha_key, { action: "test" })
            .then(function (token) {
              // Get form information
              let name = $("#contact-from-name").val();
              let email = $("#contact-from-email").val();
              let body = simplemde.value();
              // Reset notification
              resetNotification($("#notification"));

              // Then, send request to server
              $.ajax({
                method: "get",
                url: "php/contact.php",
                data: {
                  token: token,
                  name: name,
                  email: email,
                  body: body
                }
              })
                .done(function (r) {
                  if (r == "0") {
                    $("#contact-from-name, #contact-from-email, #contact-send").val("");
                    simplemde.value("");
                    $("#notification")
                      .addClass("is-success")
                      .find("p").html("Mensagem salva com sucesso!");
                  } else {
                    $("#notification")
                      .addClass("is-warning")
                      .find("p").html("O servidor recusou o pedido.");
                  }
                })
                .fail(function () {
                  $("#notification")
                    .addClass("is-warning")
                    .find("p").html("Não conseguimos entrar em contato com o servidor, tente novamente mais tarde.");
                })
                .always(function () { $("#notification").removeClass("is-hidden"); });
            });
        });
      } else {
        resetNotification($("#notification"));
        $("#notification")
          .addClass("is-warning")
          .removeClass("is-hidden")
          .find("p").html("Preencher, pelo menos, email e razão do contato.");
      }
    } else {
      resetNotification($("#notification"));
      $("#notification")
        .addClass("is-danger")
        .removeClass("is-hidden")
        .find("p").html("Informações executivas do <em>script</em> faltaram. Favor, recarregar a página antes de tentar novamente.");
    }
    $(this)
      .attr("disabled", false)
      .removeClass("is-loading");
  });

});
