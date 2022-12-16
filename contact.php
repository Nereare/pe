<?php
/**
 * Set the current page.
 */
$page = "contact";
/**
 * Set the custom script file to this page.
 */
$script = "contact";

require_once "header.php";
?>

<main class="section">
  <div class="container">
    <?php if (constant("CONTACT_WHATSAPP") != "" || constant("CONTACT_TELEGRAM") != "" || constant("CONTACT_WHATSAPP") != "" || constant("CONTACT_EMAIL") != "" || constant("CONTACT_PHONE") != "") { ?>
      <div class="box">
        <h2 class="title is-2">Redes Sociais</h2>

        <?php if (constant("CONTACT_WHATSAPP") != "" || constant("CONTACT_TELEGRAM") != "" || constant("CONTACT_WHATSAPP") != "" || constant("CONTACT_EMAIL") != "") { ?>
          <div class="columns mb-0">
            <?php if (constant("CONTACT_WHATSAPP") != "") { ?>
              <div class="column">
                <div class="field">
                  <div class="control is-expanded">
                    <a class="button is-whatsapp is-fullwidth" href="https://wa.me/<?php echo constant("CONTACT_WHATSAPP"); ?>" target="_blank">
                      <span class="icon-text">
                        <span class="icon">
                          <i class="mdi mdi-whatsapp mdi-24px"></i>
                        </span>
                        <span>WhatsApp</span>
                      </span>
                    </a>
                  </div>
                </div>
              </div>
            <?php } ?>

            <?php if (constant("CONTACT_TELEGRAM") != "") { ?>
              <div class="column">
                <div class="field">
                  <div class="control is-expanded">
                    <a class="button is-telegram is-fullwidth" href="https://t.me/<?php echo constant("CONTACT_TELEGRAM"); ?>" target="_blank">
                      <span class="icon-text">
                        <span class="icon">
                          <img src="assets/Telegram.svg">
                        </span>
                        <span>Telegram</span>
                      </span>
                    </a>
                  </div>
                </div>
              </div>
            <?php } ?>

            <?php if (constant("CONTACT_MESSENGER") != "") { ?>
              <div class="column">
                <div class="field">
                  <div class="control is-expanded">
                    <a class="button is-fb-messenger is-fullwidth" href="https://m.me/<?php echo constant("CONTACT_MESSENGER"); ?>" target="_blank">
                      <span class="icon-text">
                        <span class="icon">
                          <i class="mdi mdi-facebook-messenger mdi-24px"></i>
                        </span>
                        <span>Messenger</span>
                      </span>
                    </a>
                  </div>
                </div>
              </div>
            <?php } ?>

            <?php if (constant("CONTACT_EMAIL") != "") { ?>
              <div class="column">
                <div class="field">
                  <div class="control is-expanded">
                    <a class="button is-email is-fullwidth" href="mailto:<?php echo constant("CONTACT_EMAIL"); ?>" target="_blank">
                      <span class="icon-text">
                        <span class="icon">
                          <i class="mdi mdi-email mdi-24px"></i>
                        </span>
                        <span>Email</span>
                      </span>
                    </a>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        <?php } ?>

        <?php if (constant("CONTACT_PHONE") != "") { ?>
          <p class="is-size-4 has-text-centered mt-3">
            <span class="icon-text">
              <span class="icon">
                <i class="mdi mdi-phone"></i>
              </span>
              <span><?php echo constant("CONTACT_PHONE"); ?></span>
            </span>
          </p>
        <?php } ?>
      </div>
    <?php } ?>

    <?php if (constant("CONTACT_ADDRESS1") != "" || constant("CONTACT_PHONE") != "") { ?>
      <div class="box">
        <h2 class="title is-2">Onde nos encontrar</h2>

        <?php if (constant("CONTACT_ADDRESS1") != "") { ?>
          <p class="is-size-5 has-text-centered">
            <span class="icon-text">
              <span class="icon">
                <i class="mdi mdi-map"></i>
              </span>
              <span><?php echo constant("CONTACT_ADDRESS1"); ?></span>
            </span>
          </p>
        <?php } ?>
        <?php if (constant("CONTACT_ADDRESS2") != "") { ?>
          <p class="has-text-centered">
            <?php echo constant("CONTACT_ADDRESS2"); ?>
          </p>
        <?php } ?>
        <?php if (constant("CONTACT_ADDRESS_SHIRE") != "") { ?>
          <p class="has-text-centered">
            <?php echo constant("CONTACT_ADDRESS_SHIRE"); ?>
          </p>
        <?php } ?>
        <?php if (constant("CONTACT_ADDRESS_CITY") != "") { ?>
          <p class="has-text-centered">
            <?php echo constant("CONTACT_ADDRESS_CITY"); ?>
          </p>
        <?php } ?>
        <?php if (constant("CONTACT_ADDRESS_CODE") != "") { ?>
          <p class="has-text-centered">
            CEP <?php echo constant("CONTACT_ADDRESS_CODE"); ?>
          </p>
        <?php } ?>

        <?php if (constant("MAPS_API_KEY") != "" && constant("CONTACT_ADDRESS1") != "") { ?>
          <figure class="image is-2by1 mt-4">
            <iframe class="has-ratio" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps/embed/v1/place?key=<?php echo constant("MAPS_API_KEY"); ?>
              &q=<?php echo str_replace(" ", "+", constant("CONTACT_ADDRESS1")); ?>">
            </iframe>
          </figure>
        <?php } ?>
      </div>
    <?php } ?>

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
