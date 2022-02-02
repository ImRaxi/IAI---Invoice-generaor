<?php 

include "db_connect.php";

$conn = OpenCon();

//BUYER DATA
$existingBuyer = mysqli_real_escape_string($conn, $_POST['existing-buyer']);
$buyerName = mysqli_real_escape_string($conn, $_POST['buyer-name']);
$buyerSurname = mysqli_real_escape_string($conn, $_POST['buyer-surname']);
$buyerCompanyName = mysqli_real_escape_string($conn, $_POST['buyer-company-name']);
$buyerNip = isset($_POST['buyer-nip']) ? mysqli_real_escape_string($conn, $_POST['buyer-nip']) : '';
$buyerAddress = mysqli_real_escape_string($conn, $_POST['buyer-address']);
$buyerPostcode = mysqli_real_escape_string($conn, $_POST['buyer-postcode']);
$buyerCity = mysqli_real_escape_string($conn, $_POST['buyer-city']);

//SELLER DATA
$existingSeller = mysqli_real_escape_string($conn, $_POST['existing-seller']);
$sellerName = mysqli_real_escape_string($conn, $_POST['seller-name']);
$sellerSurname = mysqli_real_escape_string($conn, $_POST['seller-surname']);
$sellerCompanyName = mysqli_real_escape_string($conn, $_POST['seller-company-name']);
$sellerNip = isset($_POST['seller-nip']) ? mysqli_real_escape_string($conn, $_POST['seller-nip']) : '';
$sellerAddress = mysqli_real_escape_string($conn, $_POST['seller-address']);
$sellerPostcode = mysqli_real_escape_string($conn, $_POST['seller-postcode']);
$sellerCity = mysqli_real_escape_string($conn, $_POST['seller-city']);

//FV DATA
$fvPlace = mysqli_real_escape_string($conn, $_POST['fv-place']);
$dateCreate = mysqli_real_escape_string($conn, $_POST['fv-date-issue']);
$dateSale = mysqli_real_escape_string($conn, $_POST['fv-date-sale']);
$merchName = mysqli_real_escape_string($conn, $_POST['fv-merch-name']);
$fvJm = mysqli_real_escape_string($conn, $_POST['fv-jm']);
$fvAmount = mysqli_real_escape_string($conn, $_POST['fv-amount']);
$fvNetto = mysqli_real_escape_string($conn, $_POST['fv-netto']);
$fvVatPrice = isset($_POST['fv-vat-price']) ? mysqli_real_escape_string($conn, $_POST['fv-vat-price']) : '';
$fvVat = mysqli_real_escape_string($conn, $_POST['fv-vat']);
$fvBrutto = mysqli_real_escape_string($conn, $_POST['fv-brutto']);
$fvMethod = mysqli_real_escape_string($conn, $_POST['fv-payment-method']);
$fvPaymentTime = mysqli_real_escape_string($conn, $_POST['fv-payment-time']);
$fvAccountNumber = mysqli_real_escape_string($conn, $_POST['fv-account-number']);
$fvNumberGen = generateFvNumber();
$genData = date('Ymd');


//DODANIE FAKTURY
$sqlFv = "INSERT INTO `fv`(`place`, `create_date`, `sale_date`, `fv_name`, `unit`, `amount`, `netto`, `vat_percent`, `vat`, `brutto`, `type`, `deadline`, `account_number`, `fv_number`, `gen_data`) 
        VALUES ('$fvPlace', '$dateCreate', '$dateSale', '$merchName', '$fvJm', '$fvAmount', '$fvNetto', '$fvVatPrice', '$fvVat', '$fvBrutto', '$fvMethod', '$fvPaymentTime', '$fvAccountNumber', '$fvNumberGen', '$genData')";
$conn->query($sqlFv);

// DODANIE NABYWCY
$sqlBuyer = "INSERT INTO `buyers`(`buyer_name`, `buyer_surname`, `buyer_company`, `buyer_nip`, `buyer_address`, `buyer_code`, `buyer_city`, `fv_code`)
            VALUES ('$buyerName', '$buyerSurname', '$buyerCompanyName', '$buyerNip', '$buyerAddress', '$buyerPostcode', '$buyerCity', '$fvNumberGen')";
$conn->query($sqlBuyer);

// DODANIE SPRZEDAWCY 
$sqlSeller = "INSERT INTO `sellers`(`name`, `surname`, `company`, `nip`, `address`, `code`, `city`, `fv_code`)
            VALUES ('$sellerName', '$sellerSurname', '$sellerCompanyName', '$sellerNip', '$sellerAddress', '$sellerPostcode', '$sellerCity', '$fvNumberGen')";
$conn->query($sqlSeller);


header("Location: /success.php/?code=" . $fvNumberGen);

$conn->close();

function generateFvNumber() {
    $code = date('Ymd') . '/' . str_replace(':', '', date('H:i:s'));
    return $code;
}

?>