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
        echo "problem";
        die("Connection failure: " . mysqli_connect_error());
      } 
    }

    public static function getInstance() {
      if (self::$instance == null) {
        self::$instance = new Database();
      }
      return self::$instance;
    }

    /**
     * @param array $stringList - array of strings to include
     */
    function getCommentsContaining($stringList) {
      // create query
      $regexList = $this->regexSearchStr($stringList);
      $schema = getenv("SCHEMA");
      $sql = "SELECT * FROM " 
        . $schema . ".sweetwater_test "
        . "WHERE comments REGEXP '" . $regexList 
        . "';";

      // query table
      $result = $this->database->query($sql);

      // show results
      $this->listResults($result);
    }

    /**
     * @param array $stringList - array of strings to exclude
     */
    function getCommentsExcluding($stringList) {
      // create query
      $regexList = $this->regexSearchStr($stringList);
      $schema = getenv("SCHEMA");
      $sql = "SELECT * FROM " 
        . $schema . ".sweetwater_test "
        . "WHERE NOT comments REGEXP '" . $regexList 
        . "';";

      // query table
      $result = $this->database->query($sql);

      // show results
      $this->listResults($result);
    }

    /**
     * @param object $results - sql query results
     */
    function listResults($results) {
      if (!empty($results) && $results->num_rows > 0) {
        echo "<ul>";
        while ($row = $results->fetch_assoc()) {
          echo "<li>" . $row["comments"] . "</li>";
        }
        echo "</ul>";
      } else {
        echo "No results found";
      }
    }

    /**
     * @param array $stringList - array of strings
     * @return string - of concatenated strings separated by "|"
     */
    function regexSearchStr($stringList) {
      $list = "";
      foreach ($stringList as &$item) {
        if ($list == "") {
          $list = $item;
        } else {
          $list = $list . "|" . $item;
        }
      }
      return $list;
    }

    
  }
?>