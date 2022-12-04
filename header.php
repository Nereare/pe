<?php
require "vendor/autoload.php";
require "php/meta.php";
session_start();

// Try and reach the configuration file
if ( is_readable( "php/config.php" ) ) {
  // Include configuration file
  require_once( "php/config.php" );
  $title = constant( "INSTANCE_TITLE" );

  // Try and connect to the database
  try {
    $db = new \PDO(
      "mysql:dbname=" . constant( "INSTANCE_DB_NAME" ) . ";host=localhost;charset=utf8mb4",
      constant( "INSTANCE_DB_USER" ),
      constant( "INSTANCE_DB_PASSWORD" )
    );
  } catch (\PDOException $e) { $notInstalled = true; }
} else {
  $notInstalled = true;
  $title = "Grimoire";
}

// Load Auth and Parsedown only if installed
if ( !isset($notInstalled) ) {
  $auth = new \Delight\Auth\Auth($db);
  $md   = new Parsedown();
  $md->setSafeMode(true);
}

// Parse if there is a group set
if ( !isset( $group ) ) {
  $group = null;
}
?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="194x194" href="/favicon/favicon-194x194.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/favicon/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#922610">
    <link rel="shortcut icon" href="/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#922610">
    <meta name="msapplication-TileImage" content="/favicon/mstile-144x144.png">
    <meta name="msapplication-config" content="/favicon/browserconfig.xml">
    <meta name="theme-color" content="#922610">

    <title><?php echo $title; ?></title>

    <link rel="stylesheet" href="node_modules/@mdi/font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="node_modules/typeface-libre-baskerville/index.css">
    <link rel="stylesheet" href="node_modules/typeface-montserrat/index.css">
    <link rel="stylesheet" href="node_modules/typeface-noto-sans/index.css">
    <link rel="stylesheet" href="node_modules/typeface-unifrakturcook/index.css">
    <link rel="stylesheet" href="node_modules/simplemde/dist/simplemde.min.css">
    <link rel="stylesheet" href="css/style.css">

    <script type="text/javascript" src="node_modules/jquery/dist/jquery.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="node_modules/simplemde/dist/simplemde.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="node_modules/@creativebulma/bulma-tagsinput/dist/js/bulma-tagsinput.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="node_modules/uuid/dist/umd/uuidv4.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="js/common.js" charset="utf-8"></script>
    <?php if ( isset( $script ) ) { ?>
    <script type="text/javascript" src="js/<?php echo $script; ?>.js" charset="utf-8"></script>
    <?php } ?>
  </head>

  <body>
    <?php
    if ( isset($notInstalled) ) { // If the instance is not installed:
    ?>
    <section class="hero is-primary is-fullheight">
      <div class="hero-body">
        <div class="container">
          <div class="columns mb-0 is-centered">
            <div class="column is-6">
              <div class="box">
                <div class="has-text-centered">
                  <figure class="image is-128x128 is-inline-block">
                    <img src="assets/404.png">
                  </figure>
                </div>

                <h2 class="title is-4">
                  <span class="icon-text has-text-primary">
                    <span class="icon">
                      <i class="mdi mdi-alert-circle"></i>
                    </span>
                    <span>Oopsie...</span>
                  </span>
                </h2>

                <div class="content">
                  <p>
                    We apologize for the inconvenience, but it seems this application is not yet installed.
                  </p>
                  <p>
                    Please, contact the domain manager for further information.
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
    } // If it is installed, show the page
    ?>
    <header class="hero is-primary">
      <div class="hero-head">
        <nav class="navbar">
          <div class="container">
            <div class="navbar-brand">
              <a class="navbar-item" href=".">
                <img src="assets/favicon-white.png" alt="Logo">
              </a>
              <span class="navbar-burger" data-target="navbar">
                <span></span>
                <span></span>
                <span></span>
              </span>
            </div>
            <div id="navbar" class="navbar-menu has-text-centered">
              <div class="navbar-end">
              <?php if ( $auth->isLoggedIn() ) { ?>
                <span class="navbar-item">
                  <a href="setup.php">
                    <span class="icon">
                      <i class="mdi mdi-cog"></i>
                    </span>
                    <span>Config</span>
                  </a>
                </span>
                <span class="navbar-item">
                  <a id="logout">
                    <span class="icon">
                      <i class="mdi mdi-logout"></i>
                    </span>
                    <span>Logout</span>
                  </a>
                </span>
                <span class="navbar-item">
                  <a class="button is-info is-inverted" href="profile.php">
                    <span class="icon">
                      <i class="mdi mdi-account mdi-24px"></i>
                    </span>
                    <span><?php echo $auth->getUsername(); ?></span>
                  </a>
                </span>
              <?php } else { ?>
                <span class="navbar-item">
                  <a class="button is-info is-inverted" id="login-button">
                    <span class="icon">
                      <i class="mdi mdi-account mdi-24px"></i>
                    </span>
                    <span>Login</span>
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
          <p class="subtitle">
            <?php echo constant( "INSTANCE_SUBTITLE" ); ?>
          </p>
        </div>
      </div>

      <div class="hero-foot">
        <nav class="tabs is-boxed is-fullwidth">
          <div class="container">
            <ul>
              <li<?php if ( $group == "home" ) { ?> class="is-active"<?php } ?>>
                <a href=".">Home</a>
              </li>
              <li<?php if ( $group == "beings" ) { ?> class="is-active"<?php } ?>>
                <a href="beings.php">Beings</a>
              </li>
              <li<?php if ( $group == "settlements" ) { ?> class="is-active"<?php } ?>>
                <a href="settlements.php">Settlements</a>
              </li>
              <li<?php if ( $group == "items" ) { ?> class="is-active"<?php } ?>>
                <a href="items.php">Items</a>
              </li>
              <li<?php if ( $group == "other" ) { ?> class="is-active"<?php } ?>>
                <a href="other.php">Other</a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </header>