<?php
include './con.php';
// echo '<script>console.log("Your stuff here")</script>';

$searchText = $_POST['search'];
// $searchText = "a";
if (!empty($searchText)) {
    $sql = "SELECT * FROM Menu WHERE Food LIKE '%" . $searchText . "%' order by Food  asc limit 7";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($conn));
        exit();
    }
    $search_arr = array();

    while ($row = mysqli_fetch_array($result)) {
        $search_arr[] = array("label" => $row['Food']);
        // $search_arr[] = array($row['Food']);
    }

    echo json_encode($search_arr);
    // print_r($search_arr);
}
