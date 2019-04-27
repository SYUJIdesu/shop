<?php

$m = $_POST['m'];

$hosi['M1'] = 'かに星雲';
$hosi['M31'] = 'アンドロメダ星雲';
$hosi['M42'] = 'オリオン大星雲';
$hosi['M45'] = 'スバル';
$hosi['M57'] = 'ドーナツ星雲';

foreach($hosi as $key => $val)
{
	print "{$key}、{$val}<br>";
}

print "あなたが選んだ星雲は、{$hosi[$m]}です。";

?>