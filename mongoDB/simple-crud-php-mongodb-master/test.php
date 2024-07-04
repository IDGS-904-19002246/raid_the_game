<?php
// phpinfo();

// include_once("config.php");
// $collection = $db->clt_files;
// $document = $collection->findOne(['name' => 'X - bedtrock 2.0']);
// var_dump($document);



use MongoDB\BSON\ObjectId;

// Assuming $id is your MongoDB ObjectId string
$id = "5c3a9e94502ae6000a56f6c2";

// Creating an ObjectId object
$objectId = new ObjectId($id);
echo $objectId;
// Example usage in an array
$array = array(
    '_id' => $objectId
);

// Now $array['_id'] contains the ObjectId



?>