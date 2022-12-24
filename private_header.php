<?php
/**
 * Set this page as a control-panel one.
 */
$control_panel = true;

require_once "header.php";

if (!$user->hasControlPanelAccess()) {
  http_response_code(401);
  include("401.php");
  die(1);
}

if (!isset($cp_page)) {
  $cp_page = "";
}
?>

<main class="section">
  <div class="container">
    <div class="columns mt-0 mb-0 mr-0 ml-0">
      <div class="column is-4">
        <nav class="panel is-primary">
          <p class="panel-heading">
            Configurações
          </p>
          <a class="panel-block<?php echo $cp_page == "cp_home" ? " is-active" : ""; ?>">
            <span class="panel-icon">
              <i class="mdi mdi-home mdi-18px" aria-hidden="true"></i>
            </span>
            <span>Página principal</span>
          </a>
          <!-- Artigos -->
          <?php if ($user->canWriteArticles()) { ?>
            <!-- POSTAGENS -->
            <p class="panel-tabs">
              <a class="is-active">
                <span class="icon-text">
                  <span class="icon">
                    <i class="mdi mdi-newspaper mdi-18px mb-1"></i>
                  </span>
                </span>
                <span>Posts</span>
              </a>
            </p>
            <a class="panel-block<?php echo $cp_page == "post_list" ? " is-active" : ""; ?>">
              <span class="panel-icon">
                <i class="mdi mdi-newspaper-variant-multiple mdi-18px" aria-hidden="true"></i>
              </span>
              <span>Todos os posts</span>
            </a>
            <a class="panel-block<?php echo $cp_page == "post_create" ? " is-active" : ""; ?>">
              <span class="panel-icon">
                <i class="mdi mdi-newspaper-plus mdi-18px" aria-hidden="true"></i>
              </span>
              <span>Adicionar novo</span>
            </a>
            <!-- PÁGINAS -->
            <p class="panel-tabs">
              <a class="is-active">
                <span class="icon-text">
                  <span class="icon">
                    <i class="mdi mdi-file mdi-18px mb-1"></i>
                  </span>
                </span>
                <span>Páginas</span>
              </a>
            </p>
            <a class="panel-block<?php echo $cp_page == "page_list" ? " is-active" : ""; ?>">
              <span class="panel-icon">
                <i class="mdi mdi-file-multiple mdi-18px" aria-hidden="true"></i>
              </span>
              <span>Todas as páginas</span>
            </a>
            <a class="panel-block<?php echo $cp_page == "page_create" ? " is-active" : ""; ?>">
              <span class="panel-icon">
                <i class="mdi mdi-file-plus mdi-18px" aria-hidden="true"></i>
              </span>
              <span>Adicionar nova</span>
            </a>
          <?php } ?>
          <!-- USUÁRIES -->
          <?php if ($user->canManageUsers()) { ?>
            <p class="panel-tabs">
              <a class="is-active">
                <span class="icon-text">
                  <span class="icon">
                    <i class="mdi mdi-account mdi-18px mb-1"></i>
                  </span>
                </span>
                <span>Usuários</span>
              </a>
            </p>
            <a class="panel-block<?php echo $cp_page == "user_list" ? " is-active" : ""; ?>">
              <span class="panel-icon">
                <i class="mdi mdi-account-group mdi-18px" aria-hidden="true"></i>
              </span>
              <span>Todos os usuários</span>
            </a>
            <a class="panel-block<?php echo $cp_page == "user_add" ? " is-active" : ""; ?>">
              <span class="panel-icon">
                <i class="mdi mdi-account-plus mdi-18px" aria-hidden="true"></i>
              </span>
              <span>Adicionar novo</span>
            </a>
          <?php }?>
          <!-- EU -->
          <p class="panel-tabs">
            <a class="is-active">
              <span class="icon-text">
                <span class="icon">
                  <i class="mdi mdi-account mdi-18px mb-1"></i>
                </span>
              </span>
              <span>Eu</span>
            </a>
          </p>
          <a class="panel-block<?php echo $cp_page == "user_profile" ? " is-active" : ""; ?>">
            <span class="panel-icon">
              <i class="mdi mdi-card-account-details mdi-18px" aria-hidden="true"></i>
            </span>
            <span>Perfil</span>
          </a>
          <a class="panel-block<?php echo $cp_page == "user_password" ? " is-active" : ""; ?>">
            <span class="panel-icon">
              <i class="mdi mdi-account-lock mdi-18px" aria-hidden="true"></i>
            </span>
            <span>Trocar senha</span>
          </a>
        </nav>
      </div>

      <div class="column">
