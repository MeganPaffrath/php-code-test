<?php
  class DatabaseReader {
    private $database = null;
    private $schema = null;

    public function __construct() {
      $db = Database::getInstance();
      $this->database = $db->getDatabase();
      $this->schema = getenv("SCHEMA");
    }

    /**
     * Displays comments that contain any strings within an array of strings
     * @param array $stringList - array of strings to include
     */
    function getCommentsContaining($stringList) {
      // create query
      $regexList = $this->regexSearchStr($stringList);
      $sql = "SELECT * FROM " 
        . $this->schema . ".sweetwater_test "
        . "WHERE comments REGEXP '" . $regexList 
        . "';";

      // query table
      $result = $this->database->query($sql);

      // show results
      $this->listResults($result);
    }

    /**
     * Displays comments that do not enclude any strings within an array of strings
     * @param array $stringList - array of strings to exclude
     */
    function getCommentsExcluding($stringList) {
      // create query
      $regexList = $this->regexSearchStr($stringList);
      $sql = "SELECT * FROM " 
        . $this->schema . ".sweetwater_test "
        . "WHERE NOT comments REGEXP '" . $regexList 
        . "';";

      // query table
      $result = $this->database->query($sql);

      // show results
      $this->listResults($result);
    }

    /**
     * Displays a list of comments
     * @param object $results - sql query results
     */
    function listResults($results) {
      $count = 0;
      if (!empty($results) && $results->num_rows > 0) {
        echo "<ul>";
        while ($row = $results->fetch_assoc()) {
          echo "<li>" . $row["comments"] . "</li>";
          $count++;
        }
        echo "</ul>";
        echo "Total comments in category: $count";
      } else {
        echo "No results found";
      }
    }

    /**
     * Creates regex search string from array
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