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

    function populateExpectedShipdate() {
      $schema = getenv("SCHEMA");
      $sql = "SELECT * FROM " 
        . $schema . ".sweetwater_test "
        . "WHERE comments REGEXP 'Expected Ship Date:';";
      // query table
      $result = $this->database->query($sql);

      // show results
      $this->parseAndUpdateShipdate($result);
    }

    function parseAndUpdateShipdate($results) {
      if (!empty($results) && $results->num_rows > 0) {
        echo "<ul>";
        while ($row = $results->fetch_assoc()) {
          $shipdate = substr($row["comments"], strpos($row["comments"], "Expected Ship Date:"), 28 );
          $shipdate = substr($shipdate, -9, 9);
          // $shipdate = str_replace("/", "-", $shipdate) . " 00:00:00";
          $shipdate = $this->dateFormatter($shipdate);

          // COMPARE TO PROPER FORMAT....
          if ($shipdate !== $row["shipdate_expected"]) {
            echo "<br>$shipdate !== " . $row["shipdate_expected"];
            $this->updateOrderShipdate($row["orderid"], $shipdate);
          }
        }
        echo "</ul>";
      } else {
        echo "No results found";
      }
    }

    function dateFormatter($shipdate) {
      
      $month = substr($shipdate, 1, 2);
      $day = substr($shipdate, 4, 2);
      $year = "20" . substr($shipdate, 7, 2);

      $dateFormat = "$year-$month-$day  00:00:00";

      // CHANGE TO PROPPER DATE

      echo "$shipdate -> Year: $year, month: $month, day: $day -> $dateFormat";
      str_replace("/", "-", $shipdate) . " 00:00:00";
      return $dateFormat;
    }

    function updateOrderShipdate($orderID, $shipdate) {
      $schema = getenv("SCHEMA");
      $sql = "UPDATE " . $schema . ".sweetwater_test "
        . "SET shipdate_expected='" . $shipdate 
        . "' WHERE orderid='" . $orderID . "';";
      if ($this->database->query($sql) === TRUE) {
        echo "<li>Updating id: " . $orderID 
          . "'s shipdate to " . $shipdate . "</li>";
      } else {
        echo "Record update error: " . $this->database->error;
      }
    }
  }
?>