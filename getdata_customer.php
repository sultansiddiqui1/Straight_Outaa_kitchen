<?php
include './con.php';
// echo '<script>console.log("Your stuff here")</script>';

$searchText = $_POST['search'];
// $searchText = "a";
if (!empty($searchText)) {
    $sql = "SELECT * FROM Customer WHERE CustomerID LIKE '%" . $searchText . "%' order by CustomerID  asc limit 7";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($conn));
        exit();
    }
    $search_arr = array();

    while ($row = mysqli_fetch_array($result)) {
        $search_arr[] = array("label" => $row['CustomerID']);
        // $search_arr[] = array($row['CustomerID']);
    }

    echo json_encode($search_arr);
    // print_r($search_arr);
}
