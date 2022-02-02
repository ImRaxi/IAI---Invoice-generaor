<?php include('./components/header.php'); ?>

<div class="cont">
    <div class="fv-container container">
        <i class="fas fa-check-circle"></i>
        <h1>Faktura o numerze <?php if(isset($_GET['code'])) { echo $_GET['code']; } ?> została wystawiona!</h1>
        <a href="/">Menu główne</a>
    </div>
</div>

<?php include('./components/footer.php'); ?>