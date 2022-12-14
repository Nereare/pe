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
    // Disable button
    $(this)
      .addClass("is-loading")
      .prop("disabled", true);

    // Retrieve values for ease of use.
    let username = $("#login-username").val();
    let password = $("#login-password").val();

    if (username != "" && password != "") {
      let reply = null;
      $.ajax({
        method: "GET",
        url: "php/login.php",
        data: {
          username: username,
          password: password
        }
      })
        .done(function (r) { reply = r; })
        .fail(function (r) {
          resetNotification($("#notification"));
          $("#notification")
            .addClass("is-danger")
            .removeClass("is-hidden")
            .find("p").html("We could not connect to the server.");
          // Reenable button
          $("#login-login")
            .removeClass("is-loading")
            .prop("disabled", false);
        })
        .always(function (r) {
          if (r == "0") {
            resetNotification($("#notification"));
            $("#notification")
              .addClass("is-success")
              .removeClass("is-hidden")
              .find("p").html("You are now logged in.");
            // Reload page
            location.reload();
          } else {
            resetNotification($("#notification"));
            $("#notification")
              .addClass("is-danger")
              .removeClass("is-hidden")
              .find("p").html("The user data is invalid.");
            // Focus on username field
            $("#login-username").trigger("focus");
            // Reenable button
            $("#login-login")
              .removeClass("is-loading")
              .prop("disabled", false);
          }
        });
    } else {
      // Reenable button
      $(this)
        .removeClass("is-loading")
        .prop("disabled", false);
    }
  });

  // Do logout
  $("#logout-logout").on("click", function () {
    $.ajax({
      method: "GET",
      url: "php/logout.php"
    }).always(function (r) { location.reload(); });
  });

});

function resetNotification(elem) {
  elem.removeClass("is-success is-danger is-warning is-info is-dark is-light");
  elem.addClass("is-hidden");
}

/**
 * Sets default values to SimpleMDE configuration.
 */
let simplemde_config = {
  //autoDownloadFontAwesome: false,
  indentWithTabs: false,
  toolbar: [
    {
      name: "bold",
      action: SimpleMDE.toggleBold,
      className: "mdi mdi-format-bold mdi-24px",
      title: "Bold",
    },
    {
      name: "italic",
      action: SimpleMDE.toggleItalic,
      className: "mdi mdi-format-italic mdi-24px",
      title: "Italic",
    },
    {
      name: "strikethrough",
      action: SimpleMDE.toggleStrikethrough,
      className: "mdi mdi-format-strikethrough mdi-24px",
      title: "Strikethrough",
    },
    {
      name: "sup",
      action: formatSup,
      className: "mdi mdi-format-superscript mdi-24px",
      title: "Superscript",
    },
    {
      name: "sub",
      action: formatSub,
      className: "mdi mdi-format-subscript mdi-24px",
      title: "Subscript",
    },
    {
      name: "heading",
      action: SimpleMDE.toggleItalic,
      className: "mdi mdi-format-title mdi-24px",
      title: "Heading",
    },
    "|",
    {
      name: "to-lower-case",
      action: formatToLowerCase,
      className: "mdi mdi-format-letter-case-lower mdi-24px",
      title: "Lowercase",
    },
    {
      name: "to-upper-case",
      action: formatToUpperCase,
      className: "mdi mdi-format-letter-case-upper mdi-24px",
      title: "Uppercase",
    },
    "|",
    {
      name: "code",
      action: SimpleMDE.toggleCodeBlock,
      className: "mdi mdi-xml mdi-24px",
      title: "Code",
    },
    {
      name: "quote",
      action: SimpleMDE.toggleBlockquote,
      className: "mdi mdi-format-quote-open mdi-24px",
      title: "Quote",
    },
    {
      name: "unordered-list",
      action: SimpleMDE.toggleUnorderedList,
      className: "mdi mdi-format-list-bulleted mdi-24px",
      title: "Unordered List",
    },
    {
      name: "ordered-list",
      action: SimpleMDE.toggleOrderedList,
      className: "mdi mdi-format-list-numbered mdi-24px",
      title: "Ordered List",
    },
    "|",
    {
      name: "link",
      action: SimpleMDE.drawLink,
      className: "mdi mdi-link-plus mdi-24px",
      title: "Link",
    },
    {
      name: "image",
      action: SimpleMDE.drawImage,
      className: "mdi mdi-image-plus mdi-24px",
      title: "Link",
    },
    {
      name: "table",
      action: SimpleMDE.drawTable,
      className: "mdi mdi-table-plus mdi-24px",
      title: "Link",
    },
    "|",
    {
      name: "clean-block",
      action: SimpleMDE.cleanBlock,
      className: "mdi mdi-format-clear mdi-24px",
      title: "Clear",
    }
  ],
  insertTexts: {
    foo: ["foo", "foo"]
  }
};
function formatSup(editor) {
  var cm = editor.codemirror;
  var output = '';
  var selectedText = cm.getSelection();
  var text = selectedText || "";

  output = "<sup>" + text + "</sup>";
  cm.replaceSelection(output);
}
function formatSub(editor) {
  var cm = editor.codemirror;
  var output = '';
  var selectedText = cm.getSelection();
  var text = selectedText || "";

  output = "<sub>" + text + "</sub>";
  cm.replaceSelection(output);
}
function formatToLowerCase(editor) {
  var cm = editor.codemirror;
  var output = '';
  var selectedText = cm.getSelection();
  var text = selectedText || "";

  output = text.toLowerCase();
  cm.replaceSelection(output);
}
function formatToUpperCase(editor) {
  var cm = editor.codemirror;
  var output = '';
  var selectedText = cm.getSelection();
  var text = selectedText || "";

  output = text.toUpperCase();
  cm.replaceSelection(output);
}
