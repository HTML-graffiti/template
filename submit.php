<?php
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
$title = (string)filter_input(INPUT_POST, 'title');
$contents = (string)filter_input(INPUT_POST, 'contents');
$tag = (string)filter_input(INPUT_POST, 'tag');
$label = (string)filter_input(INPUT_POST, 'label');

$fp = fopen('index.csv', 'a+b');
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
<title> Submit | 自分にまつわる事柄のリストページ </title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
$("#").load("");
})
</script>
<link rel="stylesheet" href="/coding/submit/org/book.css"/>
<style type="text/css">
</style>
</head>
<body>
<div id="header">
<a href="book.php" target="_parent">自分にまつわる事柄のリストページ </a>
<a href="submit.php" target="_parent">Submit</a>
</div>
<form action="complete.php" id="org" method="post" target="_parent">
<p><input type="text" name="title" placeholder="title" required></p>
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
<label for="list" class="label">絞り込み機能付リストと投稿フォーム</label></li>
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
<p><textarea name="contents" placeholder="about this" required></textarea></p>
</div>
<div class="reset">
<button type="submit">Submit | 投稿する</button>
</div>
</form>
</body>
</html>
