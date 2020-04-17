<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf8">
<title>MariaDB Test on Builtin Server</title>
</head>
<body>

<?php
$conn = new mysqli('localhost', 'phpusr', 'phppass', 'phpdb');
if($conn->connect_errno) {
    echo $conn->connect_errno . "" . $conn->connect_error;
}

//$conn->set_charset("utf8");

$sql = 'select * from countries';
$res = $conn->query($sql);
?>

<table border="1">
    <tr>
        <th>Id</th><th>Place</th><th>Count</th>
    </tr>
<?php
if($res):
    while($row = $res->fetch_assoc()):
?>
    <tr>
        <td><?php echo $row["id"]; ?></td>
        <td><?php echo $row["place"]; ?></td>
        <td><?php echo $row["count"]; ?></td>
    </tr>
<?php
    endwhile;
endif;

$conn->close();
?>

</body>
</html>

