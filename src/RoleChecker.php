<?php
namespace Nereare\PE;

final class RoleChecker {

  /**
   * Auth instance
   */
  private \Delight\Auth\Auth $auth;

  public function __construct(\Delight\Auth\Auth $auth) {
    if ($auth->isLoggedIn()) {
      $this->auth = $auth;
    } else {
      $this->auth = false;
    }
  }

  public function isSuper() {
    if ($this->isInitialized() && ($this->auth->hasRole(\Nereare\PE\Roles::SUPER) || $this->auth->hasRole(\Nereare\PE\Roles::SUPER))) {
      return true;
    } else {
      return false;
    }
  }
  public function isAdmin() {
    if ($this->isInitialized() && ($this->auth->hasRole(\Nereare\PE\Roles::SUPER) || $this->auth->hasRole(\Nereare\PE\Roles::ADMIN))) {
      return true;
    } else {
      return false;
    }
  }
  public function isReception() {
    if ($this->isInitialized() && ($this->auth->hasRole(\Nereare\PE\Roles::SUPER) || $this->auth->hasRole(\Nereare\PE\Roles::RECEPTION))) {
      return true;
    } else {
      return false;
    }
  }
  public function isAssistance() {
    if ($this->isInitialized() && ($this->auth->hasRole(\Nereare\PE\Roles::SUPER) || $this->auth->hasRole(\Nereare\PE\Roles::ASSISTANCE))) {
      return true;
    } else {
      return false;
    }
  }
  public function isPatient() {
    if ($this->isInitialized() && ($this->auth->hasRole(\Nereare\PE\Roles::SUPER) || $this->auth->hasRole(\Nereare\PE\Roles::PATIENT))) {
      return true;
    } else {
      return false;
    }
  }

  public function hasControlPanelAccess() {
    if ($this->isInitialized() &&
        $this->auth->hasAnyRole(\Nereare\PE\Roles::SUPER,
                                \Nereare\PE\Roles::ADMIN,
                                \Nereare\PE\Roles::RECEPTION,
                                \Nereare\PE\Roles::ASSISTANCE)) {
      return true;
    } else {
      return false;
    }
  }
  public function canManageUsers() {
    if ($this->isInitialized() &&
        $this->auth->hasAnyRole(\Nereare\PE\Roles::SUPER,
                                \Nereare\PE\Roles::ADMIN)) {
      return true;
    } else {
      return false;
    }
  }
  public function canWriteArticles() {
    if ($this->isInitialized() &&
        $this->auth->hasAnyRole(\Nereare\PE\Roles::SUPER,
                                \Nereare\PE\Roles::ADMIN,
                                \Nereare\PE\Roles::ASSISTANCE)) {
      return true;
    } else {
      return false;
    }
  }

  private function isInitialized() {
    if ($this->auth != false && $this->auth instanceof \Delight\Auth\Auth && $this->auth->isLoggedIn()) {
      return true;
    } else {
      return false;
    }
  }
}
