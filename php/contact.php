<?php
require "common.php";

if (isset($_GET["token"]) && $_GET["token"]) {
  // Check if there is all the required sent data
  if (!isset($_GET["name"]) || !isset($_GET["email"]) || !isset($_GET["body"])) {
    // Lacking required sent fields
    loggy("error", "Missing fields", "contact", "contact");
    die("1");
  }
  // Get sent data
  $captcha = $_GET["token"];
  $name    = $_GET["name"];
  $email   = $_GET["email"];
  $body    = $_GET["body"];
  // Get sender metadata
  $agent   = $_SERVER["HTTP_USER_AGENT"];
  $ip      = $_SERVER["REMOTE_ADDR"];
  $secure  = $_SERVER["REQUEST_SCHEME"] == "https" ? true : false;
  // Get reCAPTCHA response
  $response = file_get_contents(
    "https://www.google.com/recaptcha/api/siteverify?secret=" . constant("RECAPTCHA_SECRET") . "&response=" . $captcha
  );
  // And decode it
  $response = json_decode($response);

  if ($response->success) {
    if ($response->score > 0.5) {
      // Get score
      $score = $response->score;

      // Prepare SQL statement
      $stmt = $db->prepare("INSERT INTO `contactform_questions`
                              (`agent`, `ip`, `secure`, `score`, `name`, `email`, `body`)
                              VALUES
                                (:agent, :ip, :secure, :score, :sname, :email, :body)");
      // Bind variables
      $stmt->bindParam("agent",   $agent);
      $stmt->bindParam("ip",      $ip);
      $stmt->bindParam("secure",  $secure, \PDO::PARAM_BOOL);
      $stmt->bindParam("score",   $score);
      $stmt->bindParam("sname",   $name);
      $stmt->bindParam("email",   $email);
      $stmt->bindParam("body",    $body);
      // Run statement
      if ($stmt->execute()) {
        // On a SQL success
        loggy("debug", "Question saved", "contact", "contact");
        echo "0";
        exit(0);
      } else {
        // On a SQL failure
        loggy("error", "Database refused statement execution", "contact", "contact");
        die("1");
      }
    } else {
      // If score is 0.5 or lower - we consider it low
      loggy("warning", "Response not saved for low reCAPTCHA score", "contact", "contact");
      die("1");
    }
  } else {
    // The reCAPTCHA request was denied for invalid response token
    loggy("error", "Invalid reCAPTCHA reply token", "contact", "contact");
    die("1");
  }
  exit(0);
}
else {
  // No reCAPTCHA response token sent
  loggy("error", "Contact message not saved for lack of reCAPTCHA reply token", "contact", "contact");
  die("1");
}
