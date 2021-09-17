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
<title> Done | 自分にまつわる事柄のリストページ </title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta http-equiv="refresh" content="3;URL=submit.php">
<style type="text/css">
html, body {padding:0; margin:0;}
#foot {
  display:block;
  position:relative;
  top:0; left:0;
  width:100%;
  height:100vh;
}
#foot .inside h1 {
  width:50vw;
  position:absolute;
  top:47.5%; left:50%;
  padding:0; margin:0;
  transform: translate(-50%, -50%);
  font-size: 10vw; font-weight:500;
  font-family: "SF Compact", sans-serif;
}
#foot .inside p {
  font-size:2.5vw;
  width:100%;
  text-align:center;
  position:absolute;
  top:90%; left:50%;
  transform: translate(-50%, -50%);
  font-family: "SF Compact", sans-serif;
}
#foot .inside b {
  border:0.25vw solid;
  background:#fff;
  padding:0.5vw 2.5vw;
  border-radius:2rem;
}

</style>
</head>
<body>
<div id="foot">
<div class="inside">
<h1><span id="rename"></span></h1>
<p class="notice"><b>ご投稿ありがとうございました</b></p>
</div>
</div>
<script>
var text = ["Thank You","for", "Submit" ];
var counter = 0;
var elem = document.getElementById("rename");
var inst = setInterval(change, 750);

elem.innerHTML = text[counter];

function change() {
  elem.innerHTML = text[counter];
  counter++;
  if (counter >= text.length) {
    counter = 0;
  }
};
</script>

</body>
</body>
</html>
