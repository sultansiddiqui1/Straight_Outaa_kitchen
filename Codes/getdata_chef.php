<?php
include './con.php';
// echo '<script>console.log("Your stuff here")</script>';

$searchText = $_POST['search'];
// $searchText = "a";
if (!empty($searchText)) {
    $sql = "SELECT * FROM Chef WHERE Chef_ID LIKE '%" . $searchText . "%' order by Chef_ID  asc limit 7";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($conn));
        exit();
    }
    $search_arr = array();

    while ($row = mysqli_fetch_array($result)) {
        $search_arr[] = array("label" => $row['Chef_ID']);
        // $search_arr[] = array($row['Chef_ID']);
    }

    echo json_encode($search_arr);
    // print_r($search_arr);
}
