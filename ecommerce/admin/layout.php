<?php include __DIR__ . '/inc/config.php'; // Configuration php file 
?>
<?php include __DIR__ . '/inc/top.php'; // Meta data and header 
?>
<?php include __DIR__ . '/inc/nav.php'; // Navigation content 
?>

<!-- Page Content -->
<div id="page-content">
    <?php include $VIEW; ?>
</div>
<!-- END Page Content -->

<?php include __DIR__ . '/inc/footer.php'; // Footer and scripts 
?>

<?php include __DIR__ . '/inc/bottom.php'; // Close body and html tags 
?>