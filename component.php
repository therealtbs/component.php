<?php
if (php_sapi_name() !== 'cli') {
  if ($_SERVER['REQUEST_METHOD'] !== "POST") die('Nope');
}
require __DIR__ . '/vendor/autoload.php';

ob_start();
foreach (glob('tpl/*.php') as $i => $file) {
  include $file;
  ob_clean();
}
ob_end_clean();
\Component\ComponentCls::_phase2();

foreach (glob('tpl/*.php') as $i => $file) {
  ob_start();
  include $file;
  $contents = ob_get_clean();
  file_put_contents(substr(str_replace('tpl/', 'dest/', $file), 0, -4), $contents);
}
