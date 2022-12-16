<?php
/**
 * Set the current page.
 */
$page = "home";
require_once "header.php";
?>

<main class="section">
  <div class="container">
    <div class="box">
      <!-- -->
      <div class="field">
        <div class="control">
          <input type="text" class="input">
        </div>
      </div>

      <div class="field">
        <div class="control">
          <textarea class="textarea"></textarea>
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
  </div>
</main>

<?php
require_once "footer.php";
?>
