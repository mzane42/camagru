<?php
  require_once('../models/image.php');

  $total = image::total();
  $perpage = 2;
  $total_images  = $total['rows'];
  $pages  = ceil($total_images / $perpage);

  # default
  $get_pages = isset($_GET['page']) ? $_GET['page'] : 1;

  $data = array(
    'options' => array(
      'default'   => 1,
      'min_range' => 1,
      'max_range' => $pages
      )
  );

  $number = trim($get_pages);
  $number = filter_var($number, FILTER_VALIDATE_INT, $data);
  $range  = $perpage * ($number - 1);

  $prev = $number - 1;
  $next = $number + 1;
   try{
    $images = Image::all($perpage, $range);
  }
  catch(exception $e) {
    $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
    header('Location: /views/pages/error.php');
    exit;
  }
?>
