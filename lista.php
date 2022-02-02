<?php 
include "./db_files/db_connect.php";
include('./components/header.php'); 

$conn = OpenCon();

?>

<div class="cont">

        <div class="container fv-list">
            <div class="search-fv">
                <form action="/lista.php" method="get" name="search-fv" id="search-fv" class="search-fv">
                    <input name="s" type="text" class="fv-search-bar" placeholder="Szukaj po numerze faktury">
                    <input type="submit" value="Szukaj" class="fv-search-btn">
                </form>
            </div>

            <?php 
            
                $sql = "SELECT * FROM `fv` ORDER BY id DESC";
                $res = $conn->query($sql);

                if ($res->num_rows > 0) {
                    while($row = $res->fetch_assoc()) { 
                        if((isset($_GET['s']) && strpos($row['fv_number'], $_GET['s']) !== false) || !isset($_GET['s'])) { ?>
                            <div class="single-fv-zone-1">
                                <a href="invoice.php/?id=<?php echo $row['id']; ?>">
                                    <div class="single-fv-list">
                                        <div class="single-fv-left">
                                            <p><i class="fas fa-file-alt"></i>Faktura Vat <?php echo $row['fv_number']; ?></p>
                                        </div>
                                        <div class="single-fv-right">
                                            <p><i class="fas fa-eye"></i>Zobacz</p>
                                        </div>
                                    </div>
                                </a>
                                <form action="db_files/delete_fv.php" method="post" name="del-form" id="del-form">
                                    <input name="delid" type="hidden" value="<?php echo $row['id']; ?>">
                                    <button type="submit" id="del-fv-btn" class="del-fv-btn">Usuń</button>
                                </form>
                            </div>
                        <?php }?>
                    <?php }
                }

            ?>

        </div>

</div>

<?php 

include('./components/footer.php'); 
$conn->close();

?>