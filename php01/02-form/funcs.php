<?php
// ===========================================
// 共通関数ファイル
// ===========================================

/**
 * XSS対策用のエスケープ関数
 * ユーザーからの入力を安全に表示するために使用
 * 
 * @param string $value エスケープする文字列
 * @return string エスケープ済みの文字列
 */
function h($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * 日時をフォーマットする関数
 * 
 * @param string $timestamp タイムスタンプ文字列
 * @return string フォーマット済みの日時文字列
 */
function formatDate($timestamp) {
    return date('Y年m月d日 H:i', strtotime($timestamp));
}
?>

