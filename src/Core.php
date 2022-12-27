<?php
namespace Nereare\PE;

final class Core {
  private string $name;
  private array $modules;
  private array $menus;
  private \PDO $db;

  public function __construct(string $name, \PDO $db) {
    $this->name = $name;
    $this->modules = [];
    $this->db = $db;
  }

  public function attach(\Nereare\PE\Module $module) {}

  public function detach(\Nereare\PE\Module $module) {}

  public function notify() {}
}
