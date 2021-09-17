<?php
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
$title = (string)filter_input(INPUT_POST, 'title');
$contents = (string)filter_input(INPUT_POST, 'contents');
$tag = (string)filter_input(INPUT_POST, 'tag');
$label = (string)filter_input(INPUT_POST, 'label');

$fp = fopen('book.csv', 'a+b');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    flock($fp, LOCK_EX);
    fputcsv($fp, [$title, $contents, $tag, $label,]);
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
<title> 自分にまつわる事柄のリストページ </title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="org.js"></script>
<script type="text/javascript">
</script>
<link rel="stylesheet" href="book.css"/>
<style type="text/css">
.list #done {
  zoom:1.5;
  padding:1rem 1.25rem;
}
.list li span {
  animation:2s ease-in infinite fontmotion;
}
</style>
</head>
<body>

<form id="org">
<div class="search-box tag">
<ul>
<li>
<input type="radio" name="tag" value="bookcover" id="bookcover">
<label for="bookcover" class="label">開いた本のようなページ</label></li>
<li>
<input type="radio" name="tag" value="book" id="book">
<label for="book" class="label">本を読むようにテキストが表示される挨拶ページ</label></li>
<li>
<input type="radio" name="tag" value="list" id="list">
<label for="list" class="label">自分にまつわる事柄のリストページ</label></li>
</ul>
</div>
<div class="search-box status">
<ul>
<li>
<input type="radio" name="label" value="a" id="a">
<label for="a" class="label">使用例</label></li>
<li>
<input type="radio" name="label" value="b" id="b">
<label for="b" class="label">応用編</label></li>
</ul>
</div>
<div class="reset">
<input type="reset" name="reset" value="RESET" class="reset-button">
</div>
</form>

<ul class="list">
<?php if (!empty($rows)): ?>
<?php foreach ($rows as $row): ?>
<li id="<?=h($row[3])?>" class="list_item list_toggle" data-tag="<?=h($row[2])?>" data-label="<?=h($row[3])?>">
<span><?=h($row[0])?></span>
<p><?=h($row[1])?></p>
<a href="<?=h($row[1])?>" target="_blank" rel="noopener noreferrer"></a>
</li>
<?php endforeach; ?>
<?php else: ?>
<li id="<?=h($row[3])?>" class="list_item list_toggle" data-tag="<?=h($row[2])?>" data-label="<?=h($row[3])?>">
<span>Title</span>
<p>contents</p>
<a href="<?=h($row[1])?>" target="_blank" rel="noopener noreferrer"></a>
</li>
<?php endif; ?>
</ul>
</body>
</html>
