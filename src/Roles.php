<?php
namespace Nereare\PE;

final class MyRole {

  // Administrative Roles
  const SUPER = \Delight\Auth\Role::SUPER_ADMIN;
  const ADMIN = \Delight\Auth\Role::ADMIN;
  const RECEPTION = \Delight\Auth\Role::COLLABORATOR;

  // Care Roles
  // Subjective
  const HISTORY_GATHERER = \Delight\Auth\Role::CREATOR;
  // Objective
  const EXAMINER = \Delight\Auth\Role::AUTHOR;
  const VITAL_SIGN_OBTAINER = \Delight\Auth\Role::CONTRIBUTOR;
  // Assessment
  const ICD_DIAGNOSER = \Delight\Auth\Role::EMPLOYEE;
  const ICPC_DIAGNOSER = \Delight\Auth\Role::DIRECTOR;
  // Plan
  const DRUG_PRESCRIBER = \Delight\Auth\Role::SUBSCRIBER;
  const PROCEDURE_PRESCRIBER = \Delight\Auth\Role::MANAGER;
  const CARE_PRESCRIBER = \Delight\Auth\Role::SUPER_EDITOR;
  const DRUG_ADMINISTRATOR = \Delight\Auth\Role::CONSULTANT;
  const PROCEDURE_DOER = \Delight\Auth\Role::TRANSLATOR;
  const SURGERY = \Delight\Auth\Role::CONSUMER;

  /*
   * Unused `\Delight\Auth\Role::*` constants:
   * --
   * COORDINATOR
   * DEVELOPER
   * EDITOR
   * MAINTAINER
   * MODERATOR
   * PUBLISHER
   * REVIEWER
   * SUPER_MODERATOR
  */

  private function __construct() {}
}
