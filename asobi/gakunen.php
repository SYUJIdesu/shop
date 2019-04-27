<?php

$gakunen = $_POST['gakunen'];

switch($gakunen)
{
	case '1':
						$kousha = '南';
						$bukatsu = '部活にはスポーツと文化部があります。';
						$mokuhyou = '学校に慣れよう';
						break;
	case '2':
						$kousha = '西';
						$bukatsu = '学園祭に向けて頑張りましょう';
						$mokuhyou = '今しかできないことをやりましょう';
						break;
	case '3':
						$kousha = '東';
						$bukatsu = '受験に向けて頑張りましょう';
						$mokuhyou = '将来への道を';
						break;
	default:
						$kousha = '3年生と同じ';
						$bukatsu = '部活はありません';
						$mokuhyou = '早く卒業しましょう';
						break;
}

print "校舎、{$kousha}・部活、{$bukatsu}・目標、{$mokuhyou}";