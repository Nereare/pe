<?php
namespace Nereare\PE;

/**
 * Undocumented interface
 */
interface Core {
  public function __construct(\PDO $db);
  public function attach(\Nereare\PE\Module $module): void;
  public function detach(\Nereare\PE\Module $module): void;
  public function notify(): void;
}
