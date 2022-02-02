<?php 
include "./db_files/db_connect.php";
include('./components/header.php'); 

$conn = OpenCon();

$sqlBuyers = "SELECT * FROM `buyers`";
$sqlSellers = "SELECT * FROM `sellers`";

$resBuyers = $conn->query($sqlBuyers);
$resSellers = $conn->query($sqlSellers);

$currentBuyer = array();
$currentSeller = array();

$currentBuyerId = isset($_GET['buyerid']) ? $_GET['buyerid'] : '';
$currentSellerId = isset($_GET['sellerid']) ? $_GET['sellerid'] : '';

$sql = "SELECT * FROM `buyers` WHERE `id` = '$currentBuyerId'";
$res = $conn->query($sql);

if (isset($_GET['buyerid']) && $_GET['buyerid'] !== -1 && $_GET['buyerid'] !== '' && $res->num_rows > 0) {
    while($row = $res->fetch_assoc()) {
        if($row['id'] === $_GET['buyerid']) {
            $currentBuyer = $row;
        }
    }
}

$sql = "SELECT * FROM `sellers` WHERE `id` = '$currentSellerId'";
$res = $conn->query($sql);

if (isset($_GET['sellerid']) && $_GET['sellerid'] !== -1 && $_GET['sellerid'] != '' && $res->num_rows > 0) {
    while($row = $res->fetch_assoc()) {
        if($row['id'] === $_GET['sellerid']) {
            $currentSeller = $row;
        }
    }
}

?>

<div class="cont">

    <form action="/nowa.php" method="get" name='autofill-form' id='autofill-form'>
        <input type="hidden" name='buyerid' id='buyerid' value='<?php if(isset($_GET['buyerid'])) { echo $_GET['buyerid']; } ?>'>
        <input type="hidden" name='sellerid' id='sellerid' value='<?php if(isset($_GET['sellerid'])) { echo $_GET['sellerid']; } ?>'>
    </form>

    <div class="container fv-cont">
        <h1>Nowa faktura</h1>

        <div class="color-line"></div>

        <form action="./db_files/new_fv.php" method="POST" id="fv-form">

            <div class="fv-zone-personal">
                <div class="single-fv-zone buyer-zone">
                    <h2>Dane nabywcy</h2>
                    <div class="color-line"></div>
                    <div class="single-input-zone">
                        <div class="or-line">
                            <div class="single-or-line"></div>
                            <div class="or-desc">Wybierz nabywcę</div>
                            <div class="single-or-line"></div>
                        </div>
                        <?php $checkArray = array(); ?>
                        <?php $skip; ?>

                        <select class="input-select" name="existing-buyer" id="existing-buyer">
                            <option value="-1">Nie wybrano</option>
                            <?php 
                                if ($resBuyers->num_rows > 0) {
                                    
                                    while($row = $resBuyers->fetch_assoc()) { 
                                        $skip = false; ?>
                                        
                                        <?php foreach($checkArray as $arr) { ?>
                                            <?php if($arr === $row['buyer_nip']) { $skip = true; } ?>
                                        <?php } ?>

                                        <?php if(!$skip) { ?>
                                            <option value="<?php echo $row['id']; ?>" <?php if(isset($_GET['buyerid']) && $_GET['buyerid'] === $row['id']) { echo 'selected'; } ?>>
                                                <?php echo $row['buyer_name'] . ' ' . $row['buyer_surname'] . ' ' . $row['buyer_nip']; ?>
                                            </option>
                                        <?php } ?>
                                        <?php array_push($checkArray, $row['buyer_nip']);?>
                                    <?php }
                                }
                            ?>
                        </select>

                        <div class="or-line">
                            <div class="single-or-line"></div>
                            <div class="or-desc">lub uzupełnij pola</div>
                            <div class="single-or-line"></div>
                        </div>
                    </div>

                    <div class="single-input-zone nomargin">
                        <label for="buyer-name">Imię</label>
                        <input type="text" class="input-field" name="buyer-name" id="buyer-name" maxlength="30" value="<?php if(!empty($currentBuyer)) { echo $currentBuyer['buyer_name']; } else { echo ''; } ?>">
                    </div>

                    <div class="single-input-zone">
                        <label for="buyer-surname">Nazwisko</label>
                        <input type="text" class="input-field" name="buyer-surname" id="buyer-surname" maxlength="30" value="<?php if(!empty($currentBuyer)) { echo $currentBuyer['buyer_surname']; } else { echo ''; } ?>">
                    </div>

                    <div class="single-input-zone">
                        <label for="buyer-company-name">Firma</label>
                        <input type="text" class="input-field" name="buyer-company-name" id="buyer-company-name" maxlength="50" value="<?php if(!empty($currentBuyer)) { echo $currentBuyer['buyer_company']; } else { echo ''; } ?>">
                    </div>

                    <div class="single-input-zone">
                        <label for="buyer-nip">NIP</label>
                        <input type="text" class="input-field" name="buyer-nip" id="buyer-nip" maxlength="10" disabled value="<?php if(!empty($currentBuyer)) { echo $currentBuyer['buyer_nip']; } else { echo ''; } ?>">
                    </div>

                    <div class="single-input-zone">
                        <label for="buyer-address">Adres</label>
                        <input type="text" class="input-field" name="buyer-address" id="buyer-address" maxlength="60" value="<?php if(!empty($currentBuyer)) { echo $currentBuyer['buyer_address']; } else { echo ''; } ?>">
                    </div>

                    <div class="single-input-zone">
                        <label for="buyer-postcode">Kod pocztowy</label>
                        <input type="text" class="input-field" name="buyer-postcode" id="buyer-postcode" maxlength="6" value="<?php if(!empty($currentBuyer)) { echo $currentBuyer['buyer_code']; } else { echo ''; } ?>">
                    </div>

                    <div class="single-input-zone">
                        <label for="buyer-city">Miasto</label>
                        <input type="text" class="input-field" name="buyer-city" id="buyer-city" maxlength="50" value="<?php if(!empty($currentBuyer)) { echo $currentBuyer['buyer_city']; } else { echo ''; } ?>">
                    </div>

                </div>

                <div class="single-fv-zone seller-zone">
                    <h2>Dane sprzedawcy</h2>
                    <div class="color-line"></div>
                    <div class="single-input-zone">
                        <div class="or-line">
                            <div class="single-or-line"></div>
                            <div class="or-desc">Wybierz sprzedawcę</div>
                            <div class="single-or-line"></div>
                        </div>
                        
                        <?php $checkArray = array(); ?>
                        <?php $skip; ?>

                        <select class="input-select" name="existing-seller" id="existing-seller">
                            <option value="-1">Nie wybrano</option>
                            <?php 
                                if ($resSellers->num_rows > 0) {
                                    
                                    while($row = $resSellers->fetch_assoc()) { 
                                        $skip = false; ?>
                                        
                                        <?php foreach($checkArray as $arr) { ?>
                                            <?php if($arr === $row['nip']) { $skip = true; } ?>
                                        <?php } ?>

                                        <?php if(!$skip) { ?>
                                            <option value="<?php echo $row['id']; ?>" <?php if(isset($_GET['sellerid']) && $_GET['sellerid'] === $row['id']) { echo 'selected'; } ?>>
                                                <?php echo $row['name'] . ' ' . $row['surname'] . ' ' . $row['nip']; ?>
                                            </option>
                                        <?php } ?>
                                        <?php array_push($checkArray, $row['nip']);?>
                                    <?php }
                                }
                            ?>
                        </select>

                        <div class="or-line">
                            <div class="single-or-line"></div>
                            <div class="or-desc">lub uzupełnij pola</div>
                            <div class="single-or-line"></div>
                        </div>
                    </div>

                    <div class="single-input-zone nomargin">
                        <label for="seller-name">Imię</label>
                        <input type="text" class="input-field" name="seller-name" id="seller-name" maxlength="30" value="<?php if(!empty($currentSeller)) { echo $currentSeller['name']; } else { echo ''; } ?>">
                    </div>

                    <div class="single-input-zone">
                        <label for="seller-surname">Nazwisko</label>
                        <input type="text" class="input-field" name="seller-surname" id="seller-surname" maxlength="30" value="<?php if(!empty($currentSeller)) { echo $currentSeller['surname']; } else { echo ''; } ?>">
                    </div>

                    <div class="single-input-zone">
                        <label for="seller-company-name">Firma</label>
                        <input type="text" class="input-field" name="seller-company-name" id="seller-company-name" maxlength="50" value="<?php if(!empty($currentSeller)) { echo $currentSeller['company']; } else { echo ''; } ?>">
                    </div>

                    <div class="single-input-zone">
                        <label for="seller-nip">NIP</label>
                        <input type="text" class="input-field" name="seller-nip" id="seller-nip" maxlength="10" disabled value="<?php if(!empty($currentSeller)) { echo $currentSeller['nip']; } else { echo ''; } ?>">
                    </div>

                    <div class="single-input-zone">
                        <label for="seller-address">Adres</label>
                        <input type="text" class="input-field" name="seller-address" id="seller-address" maxlength="60" value="<?php if(!empty($currentSeller)) { echo $currentSeller['address']; } else { echo ''; } ?>">
                    </div>

                    <div class="single-input-zone">
                        <label for="seller-postcode">Kod pocztowy</label>
                        <input type="text" class="input-field" name="seller-postcode" id="seller-postcode" maxlength="6" value="<?php if(!empty($currentSeller)) { echo $currentSeller['code']; } else { echo ''; } ?>">
                    </div>

                    <div class="single-input-zone">
                        <label for="seller-city">Miasto</label>
                        <input type="text" class="input-field" name="seller-city" id="seller-city" maxlength="50" value="<?php if(!empty($currentSeller)) { echo $currentSeller['city']; } else { echo ''; } ?>">
                    </div>

                </div>

                <div class="single-fv-zone fv-data-zone">
                    <h2>Dane faktury</h2>
                    <div class="color-line"></div>

                    <div class="fv-date-zone">

                        <div class="single-input-zone">
                            <label for="fv-place">Miejsce wystawienia</label>
                            <input type="text" class="input-field" name="fv-place" id="fv-place" maxlength="50">
                        </div>

                        <div class="single-input-zone">
                            <label for="fv-date-issue">Data wystawienia</label>
                            <input type="date" class="input-field" name="fv-date-issue" id="fv-date-issue">
                        </div>

                        <div class="single-input-zone">
                            <label for="fv-date-sale">Data sprzedaży</label>
                            <input type="date" class="input-field" name="fv-date-sale" id="fv-date-sale">
                        </div>

                    </div>

                    <div class="or-line">
                        <div class="single-or-line"></div>
                        <div class="or-desc">Towar lub usługa</div>
                        <div class="single-or-line"></div>
                    </div>


                    <div class="single-input-zone">
                        <label for="fv-merch-name">Nazwa usługi</label>
                        <input type="text" class="input-field" name="fv-merch-name" id="fv-merch-name" maxlength="200">
                    </div>

                    <div class="merch">

                        <div class="single-input-zone">
                            <label for="fv-jm">Jednostka miary</label>
                            <select class="input-select" name="fv-jm" id="fv-jm" id="fv-jm">
                                <option value="1">szt.</option>
                            </select>
                        </div>

                        <div class="single-input-zone">
                            <label for="fv-amount">Ilość</label>
                            <input type="number" class="input-field" name="fv-amount" id="fv-amount" maxlength="10">
                        </div>

                        <div class="single-input-zone">
                            <label for="fv-netto">Cena netto</label>
                            <input type="text" class="input-field" name="fv-netto" id="fv-netto" maxlength="10">
                        </div>

                        <div class="single-input-zone">
                            <label for="fv-vat">Stawka VAT</label>
                            <select class="input-select" name="fv-vat" id="fv-vat">
                                <option value="0.23">23%</option>
                                <option value="0.15">15%</option>
                                <option value="0.05">5%</option>
                            </select>
                        </div>

                        <div class="single-input-zone">
                            <label for="fv-vat-price">Kwota VAT</label>
                            <input type="text" class="input-field" name="fv-vat-price" id="fv-vat-price" disabled maxlength="10">
                        </div>

                        <div class="single-input-zone">
                            <label for="fv-brutto">Cena brutto</label>
                            <input type="text" class="input-field" name="fv-brutto" id="fv-brutto" maxlength="10">
                        </div>

                    </div>

                    <div class="or-line">
                        <div class="single-or-line"></div>
                        <div class="or-desc">Płatność</div>
                        <div class="single-or-line"></div>
                    </div>

                    <div class="fv-payment">
                        
                        <div class="single-input-zone">
                            <label for="fv-payment-method">Sposób płatności</label>
                            <select class="input-select" name="fv-payment-method" id="fv-payment-method">
                                <option value="1">Przelew</option>
                                <option value="2">Gotówka</option>
                            </select>
                        </div>

                        <div class="single-input-zone">
                            <label for="fv-payment-time">w terminie</label>
                            <select class="input-select" name="fv-payment-time" id="fv-payment-time">
                                <option value="1">7 dni</option>
                                <option value="2">14 dni</option>
                                <option value="3">30 dni</option>
                                <option value="4">60 dni</option>
                            </select>
                        </div>

                        <div class="single-input-zone">
                            <label for="fv-account-number">Numer konta</label>
                            <input type="text" class="input-field" name="fv-account-number" id="fv-account-number" maxlength = "26">
                        </div>

                    </div>

                </div>

                <div class="fv-submit-btn" id="fv-submit-btn">
                    <i class="fas fa-check-circle"></i>Wystaw fakturę
                </div>

            </div>

        </form>
    </div>

</div>

<?php 

include('./components/footer.php'); 
$conn->close();

?>