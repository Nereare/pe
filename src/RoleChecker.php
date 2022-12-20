<?php
namespace Nereare\PE;

final class RoleChecker {

  /**
   * Auth instance
   */
  private \Delight\Auth\Auth $auth;

  // Administrative Roles
  const SUPER                 = \Delight\Auth\Role::SUPER_ADMIN;
  const ADMIN                 = \Delight\Auth\Role::ADMIN;
  const RECEPTION             = \Delight\Auth\Role::COLLABORATOR;
  const ASSISTANCE            = \Delight\Auth\Role::COORDINATOR;

  // Care Roles
  // Subjective
  const HISTORY_GATHERER      = \Delight\Auth\Role::CREATOR;
  // Objective
  const EXAMINER              = \Delight\Auth\Role::AUTHOR;
  const VITAL_SIGN_OBTAINER   = \Delight\Auth\Role::CONTRIBUTOR;
  // Assessment
  const ICD_DIAGNOSER         = \Delight\Auth\Role::EMPLOYEE;
  const ICPC_DIAGNOSER        = \Delight\Auth\Role::DIRECTOR;
  // Plan
  const DRUG_PRESCRIBER       = \Delight\Auth\Role::SUBSCRIBER;
  const PROCEDURE_PRESCRIBER  = \Delight\Auth\Role::MANAGER;
  const CARE_PRESCRIBER       = \Delight\Auth\Role::SUPER_EDITOR;
  const DRUG_ADMINISTRATOR    = \Delight\Auth\Role::CONSULTANT;
  const PROCEDURE_DOER        = \Delight\Auth\Role::TRANSLATOR;
  const SURGERY               = \Delight\Auth\Role::CONSUMER;

  // Access Role
  const PATIENT = \Delight\Auth\Role::MAINTAINER;

  /*
   * Unused `\Delight\Auth\Role::*` constants:
   * --
   * DEVELOPER
   * EDITOR
   * MODERATOR
   * PUBLISHER
   * REVIEWER
   * SUPER_MODERATOR
   */

  public function __construct(\Delight\Auth\Auth $auth) {
    if ($auth->isLoggedIn()) {
      $this->auth = $auth;
    } else {
      $this->auth = false;
    }
  }

  public function isPatient() {
    if ($this->auth->hasRole(\Nereare\PE\Roles::PATIENT)) {
      return true;
    } else {
      return false;
    }
  }
}
