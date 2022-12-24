$(function() {
  console.log("Control panel ready!");

  // Start MDE
  simplemde_config["element"] = $("#cp-notepad")[0];
  let notepad = new SimpleMDE(simplemde_config);

});
