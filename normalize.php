<?php

$base_dir = __DIR__;
$db = new PDO("sqlite:{$base_dir}/db/db.sqlite");
$purchaser_insert = $db->prepare("INSERT INTO purchaser (name) VALUES (:purchaser_name)");
$merchant_insert  = $db->prepare("INSERT INTO merchant (name, address) VALUES (:merchant_name, :merchant_address)");
$item_insert      = $db->prepare("INSERT INTO item (merchant_id, price, description) VALUES (:merchant_id, :item_price, :item_description)");
$purchase_insert  = $db->prepare("INSERT INTO purchase (purchaser_id, item_id, quantity) VALUES (:purchaser_id, :item_id, :purchase_count)");

$purchaser_id_map = array();
$merchant_id_map  = array();
$item_id_map      = array();

fgets(STDIN); // discard the header
while (!feof(STDIN)) {
	$line = trim(fgets(STDIN));
	if (!$line) {
		continue;
	}

	$fields = explode("\t", $line);
	$purchaser_name   = $fields[0];
	$item_description = $fields[1];
	$item_price       = $fields[2];
	$purchase_count   = $fields[3];
	$merchant_address = $fields[4];
	$merchant_name    = $fields[5];

	if (!isset($purchaser_id_map[$purchaser_name])) {
		$purchaser_insert->execute(array(
			':purchaser_name' => $purchaser_name
		));
		$purchaser_id_map[$purchaser_name] = $db->lastInsertId();
	}
	$purchaser_id = $purchaser_id_map[$purchaser_name];

	if (!isset($merchant_id_map[$merchant_name])) {
		$merchant_insert->execute(array(
			':merchant_name'    => $merchant_name,
			':merchant_address' => $merchant_address
		));
		$merchant_id_map[$merchant_name] = $db->lastInsertId();
	}
	$merchant_id = $merchant_id_map[$merchant_name];

	if (!isset($item_id_map[$merchant_id][$item_description])) {
		$item_insert->execute(array(
			':merchant_id'      => $merchant_id,
			':item_price'       => $item_price,
			':item_description' => $item_description
		));
		$item_id_map[$merchant_id][$item_description] = $db->lastInsertId();
	}
	$item_id = $item_id_map[$merchant_id][$item_description];

	$purchase_insert->execute(array(
		':purchaser_id'   => $purchaser_id,
		':item_id'        => $item_id,
		':purchase_count' => $purchase_count
	));
}
