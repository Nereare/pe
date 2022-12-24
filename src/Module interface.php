<?php
namespace Nereare\PE;

interface Module {
  public function install(\PDO $db): bool;
  public function activate(\PDO $db): bool;
  public function deactivate(\PDO $db): bool;
  public function uninstall(\PDO $db): bool;
  public function update(\Nereare\PE\Core $core): void;
}
