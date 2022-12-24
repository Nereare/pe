<?php
require "vendor/autoload.php";
require "php/meta.php";
session_start();

// Check if there is a $page variable set
if (!isset($page)) {
  $page = null;
}

// Try and reach the configuration file
if (is_readable("php/config.php")) {
  // Include configuration file
  require_once("php/config.php");

  if (constant("PRODUCTION") && is_readable("install/")) {
    $notInstalled = true;
  }

  // Set title
  $title = constant("INSTANCE_TITLE");

  // Try and connect to the database
  try {
    $db = new \PDO(
      "mysql:dbname=" . constant("INSTANCE_DB_NAME") . ";host=localhost;charset=utf8mb4",
      constant("INSTANCE_DB_USER"),
      constant("INSTANCE_DB_PASSWORD")
    );
  } catch (\PDOException $e) {
    $notInstalled = true;
  }
} else {
  $notInstalled = true;
  $title = "PE";
}

// Load Auth and Parsedown only if installed
if (!isset($notInstalled)) {
  $auth = new \Delight\Auth\Auth($db);
  $user = new \Nereare\PE\RoleChecker($auth);
  $md   = new Parsedown();
  $md->setSafeMode(true);

  /* INSECURE Create user - for testing only.
  try {
    $userId = $auth->registerWithUniqueUsername("igorpadoim@gmail.com", "080690", "Nereare");
    echo "We have signed up a new user with the ID " . $userId;
  } catch (\Delight\Auth\InvalidEmailException $e) {
    die("Invalid email address." . $e->getMessage());
  } catch (\Delight\Auth\InvalidPasswordException $e) {
    die("Invalid password." . $e->getMessage());
  } catch (\Delight\Auth\UserAlreadyExistsException $e) {
    die("User already exists." . $e->getMessage());
  } catch (\Delight\Auth\TooManyRequestsException $e) {
    die("Too many requests." . $e->getMessage());
  } catch (\Delight\Auth\DuplicateUsernameException $e) {
    die("Duplicate username." . $e->getMessage());
  }
  */
}

// Forbid access to control-panel pages if:
// 1. Not logged-in; or
// 2. Insuficient roles.
if (isset($control_panel) && !$auth->isLoggedIn()) {
  header("");
  exit();
}
?>
<!DOCTYPE html>
<html lang="pt_BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="194x194" href="assets/favicon/favicon-194x194.png">
  <link rel="icon" type="image/png" sizes="192x192" href="assets/favicon/android-chrome-192x192.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
  <link rel="manifest" href="assets/favicon/site.webmanifest">
  <link rel="mask-icon" href="assets/favicon/safari-pinned-tab.svg" color="#4267ac">
  <link rel="shortcut icon" href="assets/favicon/favicon.ico">
  <meta name="msapplication-TileColor" content="#4267ac">
  <meta name="msapplication-TileImage" content="assets/favicon/mstile-144x144.png">
  <meta name="msapplication-config" content="assets/favicon/browserconfig.xml">
  <meta name="theme-color" content="#4267ac">

  <title><?php echo $title; ?></title>

  <link rel="stylesheet" href="node_modules/@mdi/font/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="node_modules/typeface-montserrat/index.css">
  <link rel="stylesheet" href="node_modules/typeface-roboto-mono/index.css">
  <link rel="stylesheet" href="node_modules/simplemde/dist/simplemde.min.css">
  <link rel="stylesheet" href="css/style.css">

  <script type="text/javascript" src="node_modules/jquery/dist/jquery.min.js" charset="utf-8"></script>
  <script type="text/javascript" src="node_modules/simplemde/dist/simplemde.min.js" charset="utf-8"></script>
  <script type="text/javascript" src="node_modules/uuid/dist/umd/uuidv4.min.js" charset="utf-8"></script>
  <script type="text/javascript" src="js/common.js" charset="utf-8"></script>
  <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?render=<?php echo constant("RECAPTCHA_KEY"); ?>&trustedtypes=true"></script>
  <?php if (isset($script)) { ?>
    <script type="text/javascript" src="js/<?php echo $script; ?>.js" charset="utf-8"></script>
  <?php } ?>
</head>

<body>
  <?php
  if (isset($notInstalled)) { // If the instance is not installed:
  ?>
    <section class="hero is-primary is-fullheight">
      <div class="hero-body">
        <div class="container">
          <div class="columns mb-0 is-centered">
            <div class="column is-6">
              <div class="box">
                <div class="has-text-centered">
                  <figure class="image is-128x128 is-inline-block">
                    <img src="assets/Icon.svg">
                  </figure>
                </div>

                <h2 class="title is-4">
                  <span class="icon-text has-text-primary">
                    <span class="icon">
                      <i class="mdi mdi-alert-circle"></i>
                    </span>
                    <span>Opa...</span>
                  </span>
                </h2>

                <div class="content">
                  <p>
                    Pedimos perdão pela inconveniência, mas parece que este aplicativo ainda não está instalado.
                  </p>
                  <p>
                    Por favor, entre em contato com a gerência do domínio para mais informações.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php
    exit(0);
  }
  // If it is installed, show the page
  if (!isset($control_panel) && !isset($pront)) {
  ?>
    <!------------------------------------->
    <!--    MENU DAS PÁGINAS PÚBLICAS    -->
    <!------------------------------------->
    <header class="hero is-primary is-small">
      <div class="hero-head">
        <nav class="navbar">
          <div class="container">
            <div class="navbar-brand">
              <a class="navbar-item" href="<?php echo constant("SITE_PROTOCOL"); ?>://<?php echo constant("SITE_BASEURI"); ?>">
                <img src="assets/White-Icon.svg" alt="Logo">
              </a>
              <span class="navbar-burger">
                <span></span>
                <span></span>
                <span></span>
              </span>
            </div>
            <div class="navbar-menu">
              <div class="navbar-end">
                <?php if ($auth->isLoggedIn()) {  // Is logged in
                ?>
                  <a class="navbar-item" href="pront.php">
                    <span class="icon">
                      <i class="mdi mdi-folder"></i>
                    </span>
                    <span>Prontuário</span>
                  </a>
                  <?php if (isset($control_panel)) { ?>
                    <a class="navbar-item" href="pront.php">
                      <span class="icon">
                        <i class="mdi mdi-folder"></i>
                      </span>
                      <span>Prontuário</span>
                    </a>
                  <?php } else { ?>
                    <a class="navbar-item" href="cp.php">
                      <span class="icon">
                        <i class="mdi mdi-cog"></i>
                      </span>
                      <span>Painel de Controle</span>
                    </a>
                  <?php } ?>
                  <a class="navbar-item" id="logout-logout">
                    <span class="icon">
                      <i class="mdi mdi-logout-variant"></i>
                    </span>
                    <span>Logout</span>
                  </a>
                  <span class="navbar-item">
                    <a class="button is-info is-inverted">
                      <span class="icon">
                        <i class="mdi mdi-account mdi-24px"></i>
                      </span>
                      <span>Perfil</span>
                    </a>
                  </span>
                <?php } else { // Is NOT logged in
                ?>
                  <span class="navbar-item">
                    <a class="button is-info is-inverted" id="show-login-form">
                      <span class="icon">
                        <i class="mdi mdi-login-variant mdi-24px"></i>
                      </span>
                      <span>Entrar</span>
                    </a>
                  </span>
                <?php } ?>
              </div>
            </div>
          </div>
        </nav>
      </div>

      <div class="hero-body">
        <div class="container has-text-centered">
          <p class="title">
            <?php echo $title; ?>
          </p>
        </div>
      </div>

      <div class="hero-foot">
        <nav class="tabs is-boxed is-fullwidth">
          <div class="container">
            <ul>
              <li class="<?php echo $page == "home" ? "is-active" : ""; ?>">
                <a>Home</a>
              </li>
              <li class="<?php echo $page == "foo" ? "is-active" : ""; ?>">
                <a>Modifiers</a>
              </li>
              <li class="<?php echo $page == "contact" ? "is-active" : ""; ?>">
                <a href="contact.php">
                  <span class="icon">
                    <i class="mdi mdi-message-question"></i>
                  </span>
                  <span>Contato</span>
                </a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </header>
  <?php } else { ?>
    <!------------------------------------->
    <!--     MENU DO SISTEMA INTERNO     -->
    <!------------------------------------->
    <header class="navbar is-primary" role="navigation" aria-label="main navigation">
      <div class="navbar-brand">
        <a class="navbar-item" href="<?php echo constant("SITE_PROTOCOL"); ?>://<?php echo constant("SITE_BASEURI"); ?>cp.php">
          <img src="assets/White-Icon.svg" alt="Logo">
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbar">
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
        </a>
      </div>

      <div id="navbar" class="navbar-menu">
        <div class="navbar-end">
          <a class="navbar-item" href="<?php echo constant("SITE_PROTOCOL"); ?>://<?php echo constant("SITE_BASEURI"); ?>">
            <span class="icon">
              <i class="mdi mdi-home"></i>
            </span>
            <span>Home</span>
          </a>

          <a class="navbar-item" href="pront.php">
            <span class="icon">
              <i class="mdi mdi-folder"></i>
            </span>
            <span>Prontuário</span>
          </a>

          <a class="navbar-item" id="logout-logout">
            <span class="icon">
              <i class="mdi mdi-logout-variant"></i>
            </span>
            <span>Logout</span>
          </a>

          <span class="navbar-item">
            <a class="button is-info is-inverted">
              <span class="icon">
                <i class="mdi mdi-account mdi-24px"></i>
              </span>
              <span>Perfil</span>
            </a>
          </span>
        </div>
      </div>
    </header>
  <?php } ?>
