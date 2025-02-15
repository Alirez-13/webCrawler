<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
        }
        .search-box {
            padding: 10px;
            width: 250px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .search-button {
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }
        .search-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<form action="" method="POST">
    <input type="text" name="query" class="search-box" placeholder="Search...">
    <button type="submit" class="search-button">Search</button>
</form>
</body>
</html>

<?php
include_once('SaveWebContents.php');
$save = SaveWebContents::getInstance();
$search = '';
$res = array();
$query = "";
if (isset($_POST['query'])) {
    $userSearch = $_POST['query'];
//    $queryString = "";
//    foreach ($userSearch as $value) {//Plain_Text LIKE
//        $search[] = "Plain_Text LIKE '%" . $value . "%'";
//    }
//    $query .= implode(' ', $search);
//    $res = $save->searchPageContent($query);

    // Tokenized each word
//    $tokenized = strtok($userSearch, ' ');
//    while ($tokenized !== false) {
//        $queryString .= "(CONVERT(Plain_Text USING utf8) LIKE '%$tokenized%') AND";
//        $tokenized = strtok(' ');
//    }
    $search = $save->searchPageContent($userSearch);
//    print_r($search);
}


$table = table_cell($search);
echo $table;
function table_cell($data)
{

    $return = "<table border='1'>";
    foreach ($data as $key => $value) {
        $return .= "<tr><td>$key</td><td>";
        if (is_array($value)) {
            $return .= table_cell($value);
        } else {
            $return .= $value;
        }
        $return .= "</td><tr>";
    }
    $return .= "</tr></table>";
    return ($return);

}

?>





