<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

// filetypes to display
  $imagetypes = array("image/jpeg", "image/jpg", "regular file");

  // Original PHP code by Chirp Internet: www.chirp.com.au
  // Please acknowledge use of this code by including this header.

  function dd($var) {
    var_dump($var);
    exit;
  }

  function getImages($dir)
  {
    global $imagetypes;

    // array to hold return value
    $retval = array();

    // add trailing slash if missing
    if(substr($dir, -1) != "/") $dir .= "/";

    // full server path to directory
    $fulldir = "{$_SERVER['DOCUMENT_ROOT']}/$dir";
    
    $d = @dir($fulldir) or die("getImages: Failed opening directory $dir for reading");
    while(false !== ($entry = $d->read())) {
      // skip hidden files
      if($entry[0] == ".") continue;

      // check for image files
      $f = escapeshellarg("$fulldir$entry");
      $mimetype = trim(`file -bi $f`);
      // dd($mimetype);
      foreach($imagetypes as $valid_type) {
        if(preg_match("@^{$valid_type}@", $mimetype)) {
          $retval[] = array(
           'file' => "/$dir$entry",
           'size' => getimagesize("$fulldir$entry")
          );
          break;
        }
      }
    }
    $d->close();

    return $retval;
  }

  $return_array = array();
  $images = getImages('fwlawncare/web/img/gallery');
  foreach ($images as $key => $image) {
    $new = array(
      'src' => $image['file'],
      'msrc' => $image['file'],
      'w' => $image['size'][0],
      'h' => $image['size'][1]
      );
    array_push($return_array, $new);
  }

  print_r(json_encode($return_array));
?>