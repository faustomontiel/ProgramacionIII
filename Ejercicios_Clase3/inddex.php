<?php


foreach ($_FILES as $item)
  if(file_exists($item["name"]))
  {
    move_uploaded_file($item["tmp_name"],"./backup/" . $item["name"]);
  }else{
    move_uploaded_file($item["tmp_name"],$item["name"]);
  }
?>
