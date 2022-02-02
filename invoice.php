<?php 
include "./db_files/db_connect.php";
include('./components/header.php'); 

$conn = OpenCon();

$fvId = $_GET['id'];
$sql = "SELECT `fv_number` FROM `fv` WHERE `id` = '$fvId'";
$res = $conn->query($sql);

$num = $res->fetch_assoc()['fv_number'];

$sql = "SELECT b.*, s.*, fv.*
        FROM 
            `fv` fv
        INNER JOIN
            `buyers` b ON b.fv_code = '$num'
        INNER JOIN
            `sellers` s ON s.fv_code = '$num'
        WHERE
            fv.fv_number = '$num'";

$res = $conn->query($sql);

$tabs = $res->fetch_assoc();
?>

<div class="cont">
    <div class="container invoice-container">
        <div class="row">
            <div class="col-6 invoice-container-left">

            </div>
            <div class="col-6 invoice-container-right">
                <p class="invoice-title">Miejsce wystawienia</p>
                <p><?php echo verifyData($tabs['place']); ?> </p>
                <p class="invoice-title">Data wystawienia</p>
                <p><?php echo verifyData($tabs['create_date']); ?> </p>
                <p class="invoice-title">Data sprzedaży</p>
                <p><?php echo verifyData($tabs['sale_date']); ?> </p>
            </div>
        </div>

        <div class="row row-2">
            <div class="col-6 invoice-container-left">
                <p class="invoice-title">Sprzedawca</p>
                <p><?php echo verifyData($tabs['name']) . ' ' . verifyData($tabs['surname']); ?> 
                <br> <?php echo verifyData($tabs['company']); ?> 
                <br> NIP: <?php echo verifyData($tabs['nip']) ?> 
                <br> <?php echo verifyData($tabs['address']) ?> 
                <br><?php echo verifyData($tabs['code']) . ' ' . verifyData($tabs['city']); ?></p>
            </div>
            <div class="col-6 invoice-container-right">
                <p class="invoice-title">Nabywca</p>
                <p><?php echo verifyData($tabs['buyer_name']) . ' ' . verifyData($tabs['buyer_surname']); ?> 
                <br> <?php echo verifyData($tabs['buyer_company']); ?> 
                <br> NIP: <?php echo verifyData($tabs['buyer_nip']) ?> 
                <br> <?php echo verifyData($tabs['buyer_address']) ?> 
                <br><?php echo verifyData($tabs['buyer_code']) . ' ' . verifyData($tabs['buyer_city']); ?></p>
            </div>
        </div>

        <div class="row-3">
            <h1>Faktura Vat <?php echo verifyData($tabs['fv_number']); ?> </h1>
        </div>

        <table>
            <tr>
                <th>Lp.</th>
                <th>Nazwa towaru lub usługi</th>
                <th>Jm.</th>
                <th>Ilość</th>
                <th>Cena netto</th>
                <th>Wartość netto</th>
                <th>Stawka Vat</th>
                <th>Kwota Vat</th>
                <th>Wartość brutto</th>
            </tr>
            <tr>
                <td>1</td>
                <td><?php echo verifyData($tabs['fv_name']); ?></td>
                <td>szt. </td>
                <td><?php echo verifyData($tabs['amount']); ?> </td>
                <td><?php echo verifyData($tabs['netto']); ?> </td>
                <td><?php echo verifyData($tabs['netto']); ?> </td>
                <td><?php echo verifyData($tabs['vat_percent']); ?> </td>
                <td><?php echo verifyData(floatval($tabs['vat']) * 100) . '%'; ?> </td>
                <td><?php echo verifyData($tabs['brutto']); ?> </td>
            </tr>
        </table>

        <div class="row row-4">
            <div class="col-6 invoice-container-left">
                <p>Sposób płatności: <?php echo  typeInterpreter(verifyData($tabs['type'])) . ' w terminie ' . deadlineInterpreter(verifyData($tabs['deadline'])) . ' dni.'; ?> </p>
                <p>Numer konta: <?php echo verifyData($tabs['account_number']); ?></p>
            </div>
            <div class="col-6 invoice-container-right">
                <p class="to-pay">Do zapłaty <?php echo verifyData($tabs['brutto']); ?> PLN</p>
            </div>
        </div>
    </div>
</div>

<?php 

 function verifyData($val) {
    if(!isset($val) || $val === '') {
        return '';
    } else {
        return $val;
    }
 }

 function typeInterpreter($val) {
    if($val == 1) return 'przelew';
        return 'gotówka';
 }

 function deadlineInterpreter($val) {
    switch(intval($val)) {
        case 1:
            return 7;
            break;
        case 2:
            return 14;
            break;
        case 3:
            return 30;
            break;
        case 4:
            return 60;
            break;
        default:
            return 0;
    }
 }

include('./components/footer.php'); 
$conn->close();

?>