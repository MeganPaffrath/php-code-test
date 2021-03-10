<?php
  class Database {
    private static $instance = null;
    private $database = null;

    private function __construct() {
      $host = getenv("HOST");
      $username = getenv("USERNAME");
      $password = getenv("PASSWORD");

      $this->database = mysqli_connect($host, $username, $password);
      if (!$this->database) {
        echo "Database failed to connect...";
        die("Connection failure: " . mysqli_connect_error());
      }
    }

    public static function getInstance() {
      if (self::$instance == null) {
        self::$instance = new Database();
      }
      return self::$instance;
    }

    public function getDatabase() {
      return $this->database;
    }
  }
?>