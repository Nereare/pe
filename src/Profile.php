<?php
namespace Nereare\PE;

final class Profile {

  private $db;
  private $uid;
  private $profile_created;

  /**
   * Creates a new profile manager object.
   *
   * The profile manager object references either no user at all, or only a
   * single user.
   *
   * Once created, you cannot change the user (or lack thereof).
   *
   * @param \PDO   $databaseConn  An open PDO database connection.
   * @param int    $uid           The numeric user ID.
   *
   * @throws Exception            Thrown if the given ID does not represent a valid user in the database.
   * @throws PDOException         Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   */
  public function __construct($databaseConn, $uid) {
    $this->db = $databaseConn;
    if (gettype($uid) == "integer" && $uid != null && $uid > 0) {
      $this->uid = (int)$uid;

      // This statement fetching is meant to only check if the given UID
      // corresponds to an existing user in Auth's database.
      try {
        $stmt = $this->db->prepare(
          "SELECT `id` FROM `users`
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->execute();
        if (!$stmt->fetch()) { throw new \Exception("No such user."); }
      } catch (\PDOException $e) { throw new \PDOException("Database execution error."); }


      // This statement fetching is meant to only check if the given UID
      // corresponds to an existing profile.
      try {
        $stmt = $this->db->prepare(
          "SELECT `id` FROM `users_profiles`
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->execute();
        if (!$stmt->fetch()) { $profile_created = false; }
        else { $profile_created = true; }
      } catch (\PDOException $e) { throw new \PDOException("Database execution error."); }
    } else { throw new \Exception("No given user ID."); }
  }

  /***********************************************************************/
  /*                         GET CLASS VARIABLES                         */
  /***********************************************************************/

  /**
   * Returns the classe's database connection object.
   *
   * @return \PDO  The current database connection object.
   */
  public function getDB() {
    return $this->db;
  }

  /**
   * Returns the numeric ID of the current user.
   *
   * @return int  The numeric User ID.
   */
  public function getUid() {
    return $this->uid;
  }

  /**
   * Returns whether or not the current user has a profile.
   *
   * @return bool  True if the user has a profile, false otherwise.
   */
  public function hasProfile() {
    return $this->profile_created;
  }

  /***********************************************************************/
  /*                       PROFILE CREATION METHOD                       */
  /***********************************************************************/

  /**
   * Creates the register in database of an user's profile.
   *
   * This method creates a profile for an user, given the profile manager object
   * created references one.
   *
   * If there is no user set, it throws an exception.
   *
   * @param  string $first_name         The first name of the user.
   * @param  string $last_name          The last (and possibly middle) name/s of the user.
   * @param  string $birth              The date of birth in the ISO 8601 format.
   * @param  string $register_type      A string of the accronym of the registration type (e.g. CRM, COREN, RG, CPF.)
   * @param  string $register_location  A string of the accronym of the state from which the register comes (e.g. ES, BA, RN, AM.)
   * @param  string $register_id        A string representing the number/ID of the register.
   * @param  string $cv                 A URI string to the user's curriculum vitae - optional.
   * @param  string $homepage           A URI string to the user's website home page - optional.
   * @param  string $email              The email of the user - optional.
   * @param  string $phone              The phone number of the user - optional.
   * @param  string $facebook           The user's username/tag in this social network - optional.
   * @param  string $youtube            The user's username/tag in this social network - optional.
   * @param  string $instagram          The user's username/tag in this social network - optional.
   * @param  string $tiktok             The user's username/tag in this social network - optional.
   * @param  string $telegram           The user's username/tag in this social network - optional.
   * @param  string $pinterest          The user's username/tag in this social network - optional.
   * @param  string $twitter            The user's username/tag in this social network - optional.
   * @param  string $reddit             The user's username/tag in this social network - optional.
   * @param  string $linkedin           The user's username/tag in this social network - optional.
   * @throws Exception                  Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   *
   * @return void
   */
  public function create( $first_name,
                          $last_name,
                          $birth,
                          $register_type,
                          $register_location,
                          $register_id,
                          $cv = null,
                          $homepage = null,
                          $email = null,
                          $phone = null,
                          $facebook = null,
                          $youtube = null,
                          $instagram = null,
                          $tiktok = null,
                          $telegram = null,
                          $pinterest = null,
                          $twitter = null,
                          $reddit = null,
                          $linkedin = null ) {
    try { $dob = new \DateTime($birth); }
    catch (\Exception $e) { $dob = new \DateTime(); }
    $dob = $dob->format('Y-m-d');

    try {
      $stmt = $this->db->prepare(
        "INSERT INTO `users_profiles`
          (`id`, `first_name`, `last_name`, `birth`, `register_type`, `register_location`, `register_id`, `cv`, `homepage`, `email`, `phone`, `facebook`, `youtube`, `instagram`, `tiktok`, `telegram`, `pinterest`, `twitter`, `reddit`, `linkedin`)
          VALUES (:uid, :first_name, :last_name, :birth, :register_type, :register_location, :register_id, :cv, :homepage, :email, :phone, :facebook, :youtube, :instagram, :tiktok, :telegram, :pinterest, :twitter, :reddit, :linkedin)"
      );
      $stmt->bindParam(":uid", $this->uid);
      $stmt->bindParam(":first_name", $first_name);
      $stmt->bindParam(":last_name", $last_name);
      $stmt->bindParam(":birth", $birth);
      $stmt->bindParam(":register_type", $register_type);
      $stmt->bindParam(":register_location", $register_location);
      $stmt->bindParam(":register_id", $register_id);
      $stmt->bindParam(":cv", $cv);
      $stmt->bindParam(":homepage", $homepage);
      $stmt->bindParam(":email", $email);
      $stmt->bindParam(":phone", $phone);
      $stmt->bindParam(":facebook", $facebook);
      $stmt->bindParam(":youtube", $youtube);
      $stmt->bindParam(":instagram", $instagram);
      $stmt->bindParam(":tiktok", $tiktok);
      $stmt->bindParam(":telegram", $telegram);
      $stmt->bindParam(":pinterest", $pinterest);
      $stmt->bindParam(":twitter", $twitter);
      $stmt->bindParam(":reddit", $reddit);
      $stmt->bindParam(":linkedin", $linkedin);
      $stmt->execute();

      $this->profile_created = true;
    } catch (\PDOException $e) { throw new \Exception("Database execution error."); }
  }

  /***********************************************************************/
  /*                          GET & SET METHODS                          */
  /***********************************************************************/

  /**
   * Retrieves the first name of the user..
   *
   * @throws PDOException  Thrown on query execution errors/exceptions.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return string  The first name of the user..
   */
  public function getFirstName()
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "SELECT `first_name` FROM `users_profiles`
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
          return false;
        }
        return $result["first_name"];
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to get data from.");
    }
  }
  /**
   * Sets a new value to the first name of the user..
   *
   * @param  string $new_value  The new first name of the user..
   *
   * @throws PDOException  Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return void
   */
  public function setFirstName($new_value)
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "UPDATE `users_profiles` SET
            `first_name` = :new_value
            WHERE `id` = :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->bindParam(":new_value", $new_value);
        $stmt->execute();
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to change data in.");
    }
  }

  /**
   * Retrieves the last (and possibly middle) name/s of the user..
   *
   * @throws PDOException  Thrown on query execution errors/exceptions.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return string  The last (and possibly middle) name/s of the user..
   */
  public function getLastName()
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "SELECT `last_name` FROM `users_profiles`
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
          return false;
        }
        return $result["last_name"];
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to get data from.");
    }
  }
  /**
   * Sets a new value to the last (and possibly middle) name/s of the user..
   *
   * @param  string $new_value  The new last (and possibly middle) name/s of the user..
   *
   * @throws PDOException  Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return void
   */
  public function setLastName($new_value)
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "UPDATE `users_profiles` SET
            `last_name` = :new_value
            WHERE `id` = :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->bindParam(":new_value", $new_value);
        $stmt->execute();
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to change data in.");
    }
  }

  /**
   * Retrieves the date of birth, use the ISO 8601 format..
   *
   * @throws PDOException  Thrown on query execution errors/exceptions.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return string  The date of birth, use the ISO 8601 format..
   */
  public function getBirth()
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "SELECT `birth` FROM `users_profiles`
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
          return false;
        }
        return $result["birth"];
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to get data from.");
    }
  }
  /**
   * Sets a new value to the date of birth, use the ISO 8601 format..
   *
   * @param  string $new_value  The new date of birth, use the ISO 8601 format..
   *
   * @throws PDOException  Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return void
   */
  public function setBirth($new_value)
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "UPDATE `users_profiles` SET
            `birth` = :new_value
            WHERE `id` = :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->bindParam(":new_value", $new_value);
        $stmt->execute();
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to change data in.");
    }
  }

  /**
   * Retrieves the registration type (e.g. CRM, COREN, RG, CPF.).
   *
   * @throws PDOException  Thrown on query execution errors/exceptions.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return string  The registration type (e.g. CRM, COREN, RG, CPF.).
   */
  public function getRegisterType()
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "SELECT `register_type` FROM `users_profiles`
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
          return false;
        }
        return $result["register_type"];
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to get data from.");
    }
  }
  /**
   * Sets a new value to the registration type (e.g. CRM, COREN, RG, CPF.).
   *
   * @param  string $new_value  The new registration type (e.g. CRM, COREN, RG, CPF.).
   *
   * @throws PDOException  Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return void
   */
  public function setRegisterType($new_value)
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "UPDATE `users_profiles` SET
            `register_type` = :new_value
            WHERE `id` = :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->bindParam(":new_value", $new_value);
        $stmt->execute();
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to change data in.");
    }
  }

  /**
   * Retrieves the state from which the register comes (e.g. ES, BA, RN, AM.).
   *
   * @throws PDOException  Thrown on query execution errors/exceptions.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return string  The state from which the register comes (e.g. ES, BA, RN, AM.).
   */
  public function getRegisterLocation()
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "SELECT `register_location` FROM `users_profiles`
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
          return false;
        }
        return $result["register_location"];
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to get data from.");
    }
  }
  /**
   * Sets a new value to the state from which the register comes (e.g. ES, BA, RN, AM.).
   *
   * @param  string $new_value  The new state from which the register comes (e.g. ES, BA, RN, AM.).
   *
   * @throws PDOException  Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return void
   */
  public function setRegisterLocation($new_value)
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "UPDATE `users_profiles` SET
            `register_location` = :new_value
            WHERE `id` = :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->bindParam(":new_value", $new_value);
        $stmt->execute();
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to change data in.");
    }
  }

  /**
   * Retrieves the number/ID of the register..
   *
   * @throws PDOException  Thrown on query execution errors/exceptions.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return string  The number/ID of the register..
   */
  public function getRegisterID()
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "SELECT `register_id` FROM `users_profiles`
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
          return false;
        }
        return $result["register_id"];
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to get data from.");
    }
  }
  /**
   * Sets a new value to the number/ID of the register..
   *
   * @param  string $new_value  The new number/ID of the register..
   *
   * @throws PDOException  Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return void
   */
  public function setRegisterID($new_value)
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "UPDATE `users_profiles` SET
            `register_id` = :new_value
            WHERE `id` = :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->bindParam(":new_value", $new_value);
        $stmt->execute();
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to change data in.");
    }
  }

  /**
   * Retrieves the user's curriculum vitae. This is an optional data..
   *
   * @throws PDOException  Thrown on query execution errors/exceptions.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return string  The user's curriculum vitae. This is an optional data..
   */
  public function getCV()
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "SELECT `cv` FROM `users_profiles`
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
          return false;
        }
        return $result["cv"];
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to get data from.");
    }
  }
  /**
   * Sets a new value to the user's curriculum vitae. This is an optional data..
   *
   * @param  string $new_value  The new user's curriculum vitae. This is an optional data..
   *
   * @throws PDOException  Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return void
   */
  public function setCV($new_value)
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "UPDATE `users_profiles` SET
            `cv` = :new_value
            WHERE `id` = :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->bindParam(":new_value", $new_value);
        $stmt->execute();
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to change data in.");
    }
  }

  /**
   * Retrieves the user's website home page. This is an optional data..
   *
   * @throws PDOException  Thrown on query execution errors/exceptions.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return string  The user's website home page. This is an optional data..
   */
  public function getHomepage()
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "SELECT `homepage` FROM `users_profiles`
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
          return false;
        }
        return $result["homepage"];
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to get data from.");
    }
  }
  /**
   * Sets a new value to the user's website home page. This is an optional data..
   *
   * @param  string $new_value  The new user's website home page. This is an optional data..
   *
   * @throws PDOException  Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return void
   */
  public function setHomepage($new_value)
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "UPDATE `users_profiles` SET
            `homepage` = :new_value
            WHERE `id` = :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->bindParam(":new_value", $new_value);
        $stmt->execute();
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to change data in.");
    }
  }

  /**
   * Retrieves the email of the user. This is an optional data..
   *
   * @throws PDOException  Thrown on query execution errors/exceptions.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return string  The email of the user. This is an optional data..
   */
  public function getEmail()
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "SELECT `email` FROM `users_profiles`
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
          return false;
        }
        return $result["email"];
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to get data from.");
    }
  }
  /**
   * Sets a new value to the email of the user. This is an optional data..
   *
   * @param  string $new_value  The new email of the user. This is an optional data..
   *
   * @throws PDOException  Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return void
   */
  public function setEmail($new_value)
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "UPDATE `users_profiles` SET
            `email` = :new_value
            WHERE `id` = :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->bindParam(":new_value", $new_value);
        $stmt->execute();
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to change data in.");
    }
  }

  /**
   * Retrieves the phone number of the user. This is an optional data..
   *
   * @throws PDOException  Thrown on query execution errors/exceptions.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return string  The phone number of the user. This is an optional data..
   */
  public function getPhone()
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "SELECT `phone` FROM `users_profiles`
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
          return false;
        }
        return $result["phone"];
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to get data from.");
    }
  }
  /**
   * Sets a new value to the phone number of the user. This is an optional data..
   *
   * @param  string $new_value  The new phone number of the user. This is an optional data..
   *
   * @throws PDOException  Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return void
   */
  public function setPhone($new_value)
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "UPDATE `users_profiles` SET
            `phone` = :new_value
            WHERE `id` = :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->bindParam(":new_value", $new_value);
        $stmt->execute();
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to change data in.");
    }
  }

  /**
   * Retrieves the user's username/tag in this social network. This is an optional data..
   *
   * @throws PDOException  Thrown on query execution errors/exceptions.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return string  The user's username/tag in this social network. This is an optional data..
   */
  public function getFacebook()
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "SELECT `facebook` FROM `users_profiles`
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
          return false;
        }
        return $result["facebook"];
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to get data from.");
    }
  }
  /**
   * Sets a new value to the user's username/tag in this social network. This is an optional data..
   *
   * @param  string $new_value  The new user's username/tag in this social network. This is an optional data..
   *
   * @throws PDOException  Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return void
   */
  public function setFacebook($new_value)
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "UPDATE `users_profiles` SET
            `facebook` = :new_value
            WHERE `id` = :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->bindParam(":new_value", $new_value);
        $stmt->execute();
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to change data in.");
    }
  }

  /**
   * Retrieves the user's username/tag in this social network. This is an optional data..
   *
   * @throws PDOException  Thrown on query execution errors/exceptions.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return string  The user's username/tag in this social network. This is an optional data..
   */
  public function getYouTube()
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "SELECT `youtube` FROM `users_profiles`
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
          return false;
        }
        return $result["youtube"];
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to get data from.");
    }
  }
  /**
   * Sets a new value to the user's username/tag in this social network. This is an optional data..
   *
   * @param  string $new_value  The new user's username/tag in this social network. This is an optional data..
   *
   * @throws PDOException  Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return void
   */
  public function setYouTube($new_value)
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "UPDATE `users_profiles` SET
            `youtube` = :new_value
            WHERE `id` = :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->bindParam(":new_value", $new_value);
        $stmt->execute();
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to change data in.");
    }
  }

  /**
   * Retrieves the user's username/tag in this social network. This is an optional data..
   *
   * @throws PDOException  Thrown on query execution errors/exceptions.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return string  The user's username/tag in this social network. This is an optional data..
   */
  public function getInstagram()
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "SELECT `instagram` FROM `users_profiles`
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
          return false;
        }
        return $result["instagram"];
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to get data from.");
    }
  }
  /**
   * Sets a new value to the user's username/tag in this social network. This is an optional data..
   *
   * @param  string $new_value  The new user's username/tag in this social network. This is an optional data..
   *
   * @throws PDOException  Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return void
   */
  public function setInstagram($new_value)
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "UPDATE `users_profiles` SET
            `instagram` = :new_value
            WHERE `id` = :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->bindParam(":new_value", $new_value);
        $stmt->execute();
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to change data in.");
    }
  }

  /**
   * Retrieves the user's username/tag in this social network. This is an optional data..
   *
   * @throws PDOException  Thrown on query execution errors/exceptions.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return string  The user's username/tag in this social network. This is an optional data..
   */
  public function getTikTok()
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "SELECT `tiktok` FROM `users_profiles`
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
          return false;
        }
        return $result["tiktok"];
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to get data from.");
    }
  }
  /**
   * Sets a new value to the user's username/tag in this social network. This is an optional data..
   *
   * @param  string $new_value  The new user's username/tag in this social network. This is an optional data..
   *
   * @throws PDOException  Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return void
   */
  public function setTikTok($new_value)
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "UPDATE `users_profiles` SET
            `tiktok` = :new_value
            WHERE `id` = :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->bindParam(":new_value", $new_value);
        $stmt->execute();
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to change data in.");
    }
  }

  /**
   * Retrieves the user's username/tag in this social network. This is an optional data..
   *
   * @throws PDOException  Thrown on query execution errors/exceptions.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return string  The user's username/tag in this social network. This is an optional data..
   */
  public function getTelegram()
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "SELECT `telegram` FROM `users_profiles`
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
          return false;
        }
        return $result["telegram"];
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to get data from.");
    }
  }
  /**
   * Sets a new value to the user's username/tag in this social network. This is an optional data..
   *
   * @param  string $new_value  The new user's username/tag in this social network. This is an optional data..
   *
   * @throws PDOException  Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return void
   */
  public function setTelegram($new_value)
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "UPDATE `users_profiles` SET
            `telegram` = :new_value
            WHERE `id` = :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->bindParam(":new_value", $new_value);
        $stmt->execute();
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to change data in.");
    }
  }

  /**
   * Retrieves the user's username/tag in this social network. This is an optional data..
   *
   * @throws PDOException  Thrown on query execution errors/exceptions.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return string  The user's username/tag in this social network. This is an optional data..
   */
  public function getPinterest()
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "SELECT `pinterest` FROM `users_profiles`
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
          return false;
        }
        return $result["pinterest"];
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to get data from.");
    }
  }
  /**
   * Sets a new value to the user's username/tag in this social network. This is an optional data..
   *
   * @param  string $new_value  The new user's username/tag in this social network. This is an optional data..
   *
   * @throws PDOException  Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return void
   */
  public function setPinterest($new_value)
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "UPDATE `users_profiles` SET
            `pinterest` = :new_value
            WHERE `id` = :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->bindParam(":new_value", $new_value);
        $stmt->execute();
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to change data in.");
    }
  }

  /**
   * Retrieves the user's username/tag in this social network. This is an optional data..
   *
   * @throws PDOException  Thrown on query execution errors/exceptions.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return string  The user's username/tag in this social network. This is an optional data..
   */
  public function getTwitter()
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "SELECT `twitter` FROM `users_profiles`
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
          return false;
        }
        return $result["twitter"];
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to get data from.");
    }
  }
  /**
   * Sets a new value to the user's username/tag in this social network. This is an optional data..
   *
   * @param  string $new_value  The new user's username/tag in this social network. This is an optional data..
   *
   * @throws PDOException  Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return void
   */
  public function setTwitter($new_value)
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "UPDATE `users_profiles` SET
            `twitter` = :new_value
            WHERE `id` = :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->bindParam(":new_value", $new_value);
        $stmt->execute();
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to change data in.");
    }
  }

  /**
   * Retrieves the user's username/tag in this social network. This is an optional data..
   *
   * @throws PDOException  Thrown on query execution errors/exceptions.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return string  The user's username/tag in this social network. This is an optional data..
   */
  public function getReddit()
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "SELECT `reddit` FROM `users_profiles`
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
          return false;
        }
        return $result["reddit"];
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to get data from.");
    }
  }
  /**
   * Sets a new value to the user's username/tag in this social network. This is an optional data..
   *
   * @param  string $new_value  The new user's username/tag in this social network. This is an optional data..
   *
   * @throws PDOException  Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return void
   */
  public function setReddit($new_value)
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "UPDATE `users_profiles` SET
            `reddit` = :new_value
            WHERE `id` = :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->bindParam(":new_value", $new_value);
        $stmt->execute();
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to change data in.");
    }
  }

  /**
   * Retrieves the user's username/tag in this social network. This is an optional data..
   *
   * @throws PDOException  Thrown on query execution errors/exceptions.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return string  The user's username/tag in this social network. This is an optional data..
   */
  public function getLinkedIn()
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "SELECT `linkedin` FROM `users_profiles`
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
          return false;
        }
        return $result["linkedin"];
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to get data from.");
    }
  }
  /**
   * Sets a new value to the user's username/tag in this social network. This is an optional data..
   *
   * @param  string $new_value  The new user's username/tag in this social network. This is an optional data..
   *
   * @throws PDOException  Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws Exception     Thrown when calling this method on a user with no profile created.
   *
   * @return void
   */
  public function setLinkedIn($new_value)
  {
    if ($this->profile_created) {
      try {
        $stmt = $this->db->prepare(
          "UPDATE `users_profiles` SET
            `linkedin` = :new_value
            WHERE `id` = :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->bindParam(":new_value", $new_value);
        $stmt->execute();
      } catch (\PDOException $e) {
        throw new \PDOException("Database execution error.");
      }
    } else {
      throw new \Exception("No profile created to change data in.");
    }
  }
}
