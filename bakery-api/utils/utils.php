<?php
function guidv4() {
  $data = PHP_MAJOR_VERSION < 7 ? openssl_random_pseudo_bytes(16) : random_bytes(16);
  $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // Set version to 0100
  $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // Set bits 6-7 to 10
  return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function randomLipsum($amount = 1, $what = 'paras', $start = 0) {
  return simplexml_load_file("http://www.lipsum.com/feed/xml?amount=$amount&what=$what&start=$start")->lipsum;
}

function randomNumber($length = 3) {
  $intMin = (10 ** $length) / 10; // 100...
  $intMax = (10 ** $length) - 1;  // 999...

  $codeRandom = mt_rand($intMin, $intMax);

  return $codeRandom;
}

function randomString($length = 10, $prefix = '') {
  return $prefix . substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}