<?php

$tsuki = $_POST['tsuki'];

$yasai[] = '';
$yasai[] = 'ブロッコリー';
$yasai[] = 'カリフラワー';
$yasai[] = 'レタス';
$yasai[] = 'ミツバ';
$ysaai[] = 'アスパラガス';
$yasai[] = 'セロリ';
$yasai[] = 'なす';
$yasai[] = 'ピーマン';
$yasai[] = 'オクラ';
$yasai[] = 'さつまいも';
$yasai[] = '大根';
$yasai[] = 'ほうれん草';

print "{$tsuki}月は,{$yasai[$tsuki]}が旬です";

?>