<?php
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

$name = (string)filter_input(INPUT_POST, 'name');
$title = (string)filter_input(INPUT_POST, 'title');
$link = (string)filter_input(INPUT_POST, 'link');

$fp = fopen('book.csv', 'a+b');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    flock($fp, LOCK_EX);
    fputcsv($fp, [$name, $title, $link]);
    rewind($fp);
}

flock($fp, LOCK_SH);
while ($row = fgetcsv($fp)) {
    $rows[] = $row;
}
flock($fp, LOCK_UN);
fclose($fp);

?>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title> 📝  List of The Website of Listing somethings </title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="org.js"></script>
<script type="text/javascript">
</script>
<link rel="stylesheet" href="book.css"/>
<style type="text/css">
#contents {
  margin:5vw 0 0;
}
</style>
</head>
<body>

<div id="contents">
<p class="writing">📝 List of The Website of Listing somethings</p>
<ul id="list">
<?php if (!empty($rows)): ?>
<?php foreach ($rows as $row): ?>
<li class="item">
<p class="name"><?=h($row[0])?></p>
<span class="title"><?=h($row[1])?></span>
<a class="link" href="<?=h($row[2])?>" target="_blank" rel="noopener noreferrer"></a>
</li>
<?php endforeach; ?>
<?php else: ?>
<li class="item">
<p class="name">Name</p>
<span class="title">Title</span>
<a class="link" href="" target="_blank" rel="noopener noreferrer"></a>
</li>
<?php endif; ?>
</ul>
</div>
</body>
</html>
