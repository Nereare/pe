<?php
namespace Nereare\PE;

final class Module {
  public function install(\PDO $db) {}

  public function activate(\PDO $db) {}

  public function deactivate(\PDO $db) {}

  public function uninstall(\PDO $db) {}

  public function update(\Nereare\PE\Core $core) {}
}
