<?php
$cp_page = "cp_home";
/**
 * Set the custom script file to this page.
 */
$script = "cp";
require_once "private_header.php";
?>

<div class="box">
  <!-- -->
  <div class="field">
    <div class="control">
      <input type="text" class="input">
    </div>
  </div>

  <div class="field">
    <div class="control">
      <textarea class="textarea" id="cp-notepad"></textarea>
    </div>
  </div>

  <div class="field">
    <div class="control is-expanded">
      <div class="select is-fullwidth">
        <select>
          <option value="" selected>Foo</option>
          <option value="">Bar</option>
        </select>
      </div>
    </div>
  </div>

  <!-- -->
</div>

<?php
require_once "private_footer.php";
?>
