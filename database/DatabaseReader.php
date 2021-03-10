<?php
  class DatabaseReader {
    private $database = null;

    public function __construct() {
      $this->database = Database::getInstance();
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

    /**
     * Updates sweetwater_test table if applicable
     * Shows updates made and if updates were made
     */
    function populateExpectedShipdate() {
      $sql = "SELECT * FROM " 
        . $this->schema . ".sweetwater_test "
        . "WHERE comments REGEXP 'Expected Ship Date:';";
      // query table
      $result = $this->database->query($sql);

      // update and show updates made
      $this->parseAndUpdateShipdate($result);
    }

    /**
     * Iterates through query results to update sweetwater_test table
     * @param object $results - sql query results
     */
    function parseAndUpdateShipdate($results) {
      $updates = 0;
      if (!empty($results) && $results->num_rows > 0) {
        echo "<ul>";
        while ($row = $results->fetch_assoc()) {
          $shipdate = substr($row["comments"], strpos($row["comments"], "Expected Ship Date:"), 28 );
          $shipdate = substr($shipdate, -9, 9);
          $shipdate = $this->dateFormatter($shipdate);

          // convert strings to dates
          $shipDateFormat = date('Y-m-d',strtotime($shipdate));
          $expectedShipDateFormat = date('Y-m-d', strtotime($row["shipdate_expected"]));

          // update if shipdate_expected in table does not match comment
          if ($shipDateFormat !== $expectedShipDateFormat) {
            $this->updateOrderShipdate($row["orderid"], $shipdate);
            $updates++;
          }
        }
        echo "</ul>";
        if ($updates === 0) {
          echo "<p>Database is up to date! No updates needed!</p>";
        } else {
          echo "<p>$updates update(s) made</p>";
        }
      } else {
        echo "No results found";
      }
    }

    /** 
     * Updates sweetwater_test table with new shipdate_expected
     * @param string $orderID - the SQL order id
     * @param string $shipdate - a date string in datetime format
     */
    function updateOrderShipdate($orderID, $shipdate) {
      $sql = "UPDATE " . $this->schema . ".sweetwater_test "
        . "SET shipdate_expected='" . $shipdate 
        . "' WHERE orderid='" . $orderID . "';";
      if ($this->database->query($sql) === TRUE) {
        echo "<li>Updating id: " . $orderID 
          . "'s shipdate to " . $shipdate . "</li>";
      } else {
        echo "Record update error: " . $this->database->error;
      }
    }

    /**
     * Takes date string and converts to datetime string
     * @param string $shipdate - a date in mm/dd/yy format
     * @return string - a date in yyyy-mm-dd hh:mm:ss format
     */
    function dateFormatter($shipdate) {
      $month = substr($shipdate, 1, 2);
      $day = substr($shipdate, 4, 2);
      $year = "20" . substr($shipdate, 7, 2);
      return "$year-$month-$day  00:00:00";
    }
  }
?>