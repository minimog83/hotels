<?php
/** 外部ファイルの読込み */
require_once "/pdo/use_pdo.php";
require_once "/pdo/classes.php";
?>

<?php
$hotel = -1;
if (isset($_REQUEST["hotel"])) {
	$hotel = intval($_REQUEST["hotel"]);



$pdo = connectDatabase();
// Step-3. 実行するSQLを設定（プレースホルダ付きSQL）
$sql = "select * from hotel where address like = '%%'";
// Step-4. SQL実行オブジェクトを取得
$pstmt = $pdo->prepare($sql);
// Step-5. プレースホルダにリクエストパラメータを設定
$pstmt->bindValue(1, $hotel);
// Step-6. SQLを実行
$pstmt->execute();
// Step-7. 結果セットを取得
$rs = $pstmt->fetchAll();
// Step-8. データベース接続オブジェクトを破棄
disconnectDatabase($pdo);
// Step-9. 結果セットを配列に格納

$hotels = [];
foreach ($rs as $record) {
	$id = intval($record["id"]);
	$name = $record["name"];
	$price = intval($record["price"]);
	$pref = $record["pref"];
	$city = $record["city"];
	$address = $record["address"];
	$memo = $record["memo"];
	$image = $record["image"];
	$hotel = new Hotel($id, $name, $price, $pref, $city, $address, $memo, $image);
	$hotels[] = $hotel;
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<title>ホテル検索結果一覧</title>
	<link rel="stylesheet" href="../assets/css/style.css" />
	<link rel="stylesheet" href="../assets/css/hotels.css" />
</head>

<body>
	<header>
		<h1>ホテル検索結果一覧</h1>
		<p><a href="./entry.php">検索ページに戻る</a></p>
	</header>
	<main>
		<article>
			<table>
				<tr>
				    <?php foreach ($hotels as $hotel) { ?>
					<td>
						<?= $hotel->getImage() ?>
					</td>
					<td>
						<table class="detail">
							<tr>
								<td><?= $hotel->getName() ?><br /></td>
							</tr>
							<tr>
								<td><?= $hotel->getAddress() ?></td>
							</tr>
							<tr>
								<td>宿泊料：<?= $hotel->getPrice() ?></td>
							</tr>
							<tr>
								<td></td>
							</tr>
						</table>
					</td>
					<?php } ?>
				</tr>
				
			</table>
		</article>
	</main>
	<footer>
		<div id="copyright">(C) 2019 The Web System Development Course</div>
	</footer>
</body>

</html>