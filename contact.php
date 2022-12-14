<?php

/**
 * Set the custom script file to this page.
 */
$script = "contact";

require_once "header.php";
?>

<main class="section">
  <div class="container">
    <div class="box">
      <h2 class="title is-2">Contato</h2>
      <p class="subtitle is-4">Dúvidas? Angústias? Entre em contato conosco!</p>

      <input type="hidden" id="contact-recaptcha-key" value="<?php echo constant("RECAPTCHA_KEY"); ?>">

      <div class="columns mb-0">
        <div class="column">
          <div class="field has-addons">
            <div class="control">
              <button class="button is-static" tabindex="-1">
                <span class="icon">
                  <i class="mdi mdi-account"></i>
                </span>
              </button>
            </div>
            <div class="control is-expanded">
              <input type="text" class="input" id="contact-from-name" placeholder="Nome">
            </div>
          </div>
        </div>

        <div class="column">
          <div class="field has-addons">
            <div class="control">
              <button class="button is-static" tabindex="-1">
                <span class="icon">
                  <i class="mdi mdi-email"></i>
                </span>
              </button>
            </div>
            <div class="control is-expanded">
              <input type="email" class="input" id="contact-from-email" placeholder="Email">
            </div>
          </div>
        </div>
      </div>

      <div class="field">
        <div class="control">
          <textarea class="textarea" id="contact-body" rows="10" placeholder="Por favor, nos explique a razão do contato aqui..."></textarea>
        </div>
      </div>

      <div class="field">
        <div class="control is-expanded">
          <button class="button is-success is-fullwidth" id="contact-send">Enviar</button>
        </div>
      </div>
    </div>
  </div>
</main>

<?php
require_once "footer.php";
?>
