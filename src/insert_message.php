<?php
//両端の空白を除去する関数
function mbTrim($pString)
{
    return preg_replace('/\A[\p{Cc}\p{Cf}\p{Z}]++|[\p{Cc}\p{Cf}\p{Z}]++\z/u', '', $pString);
}


// 投稿者の入力を確認
$is_valid_auther_name = true;
$input_author_name = '';
if (isset($_POST['author_name'])) {
    $input_author_name = mbTrim(str_replace("\r\n", "\n", $_POST['author_name'])); //str_replaceはOSごとの改行コードを統一する関数
} else {
    $is_valid_auther_name = false;
}

if ($is_valid_auther_name && mb_strlen($input_author_name) > 30) {
    $is_valid_auther_name = false;
} //バリデーション


//投稿内容の入力を確認
$is_valid_message = true;
$input_message = '';
if (isset($_POST['message'])) {
  $input_message = mbTrim(str_replace("\r\n", "\n", $_POST['message']));
} else {
  $is_valid_message = false;
}

if ($is_valid_message && $input_message === '') {
    $is_valid_message = false;
}

if ($is_valid_message && mb_strlen($input_message) > 1000) {
    $is_valid_message = false;
}

// 投稿をデータベースへ保存する処理
if ($is_valid_auther_name && $is_valid_message) {
  if ($input_author_name === '') {
    $input_author_name = '名無し';
  }

  // プレースホルダ(:変数)によってSQLインジェクションの対策になる！！
  $query = 'INSERT INTO posts (author_name, message) VALUES (:author_name, :message)';

  // SQL 実行の準備
  $stmt = $dbh->prepare($query);

  // プレースホルダに値をセットする
  $stmt->bindValue(':author_name', $input_author_name, PDO::PARAM_STR);
  $stmt->bindValue(':message', $input_message, PDO::PARAM_STR);

  $stmt->execute();
}

header('Location: /');
exit();