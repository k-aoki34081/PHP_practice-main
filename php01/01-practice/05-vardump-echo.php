<?php
// ===========================================
// var_dump と echo の違い
// ===========================================

// 変数を用意
$name = "どんぶラッコ";
$birthMonth = 1;
$isStudent = true;

// -----------------------------------------
// var_dump() - デバッグ用
// 変数の「値」と「型」を両方表示する
// -----------------------------------------
echo "<h2>var_dump()</h2>";
echo "<pre>";
var_dump($name);      // string(18) "どんぶラッコ"
var_dump($birthMonth);       // int(1)
var_dump($isStudent); // bool(true)
echo "</pre>";

// -----------------------------------------
// echo - 出力用
// 値をそのまま文字列として表示する
// -----------------------------------------
echo "<h2>echo</h2>";
echo $name;
echo "<br>";
echo $birthMonth;
echo "<br>";
echo $isStudent; // 文字列に変換されて 1 と表示される
?>
