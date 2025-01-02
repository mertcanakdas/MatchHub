<?php
define('security', true);
require_once 'inc/header.php';


// Kullanıcının giriş kontrolü
if (!isset($_SESSION['id'])) {
    header("Location: login.php"); // Giriş yapılmamışsa login sayfasına yönlendir
    exit();
}




// Veritabanı bağlantısı
// require_once 'inc/db.php'; // Veritabanı bağlantı dosyanız

// Kullanıcı ID'leri
$alici_id = get('userid'); // URL'den gelen kullanıcı ID
$gonderen_id = $_SESSION['id']; // Oturumdaki giriş yapan kullanıcı ID

$query = $db->prepare("SELECT bayiadi,bayilogo,bayikodu FROM bayiler WHERE id = :id");
$query->execute(['id' => $alici_id]);
$alici = $query->fetch(PDO::FETCH_ASSOC);
if ($alici) {
    $alici_adi = $alici['bayiadi'];
} else {
    $alici_adi = "Bilinmeyen Kullanıcı"; // Kullanıcı bulunamazsa varsayılan isim
}

if (!$alici_id) {
    go(site); // Kullanıcı ID yoksa anasayfaya yönlendir
}



// Mesaj gönderme işlemi
if (isset($_POST['mesajgonder'])) {
    $mesajicerik = trim($_POST['mesajicerik']); // Mesaj içeriği

    if (!empty($mesajicerik)) {
        // Mesajı veritabanına kaydet
        $query = $db->prepare("INSERT INTO mesajlar (gonderen_id, alici_id, mesajicerik, mesajtarih, mesajip) VALUES (:gonderen_id, :alici_id, :mesajicerik, NOW(), :mesajip)");
        $query->execute([
            'gonderen_id' => $gonderen_id,
            'alici_id' => $alici_id,
            'mesajicerik' => $mesajicerik,
            'mesajip' => $_SERVER['REMOTE_ADDR'], // Kullanıcının IP adresi
        ]);
    }
}



// Mesajları getirme işlemi
$query = $db->prepare("SELECT * FROM mesajlar WHERE (gonderen_id = :gonderen_id AND alici_id = :alici_id) OR (gonderen_id = :alici_id AND alici_id = :gonderen_id) ORDER BY mesajtarih ASC");
$query->execute([
    'gonderen_id' => $gonderen_id,
    'alici_id' => $alici_id,
]);
$mesajlar = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

    * {
        box-sizing: border-box;
        font-family: 'Roboto', sans-serif;
    }

    /* Styling the main container */
    .container {
        width: 80%;
        margin: auto;
        margin-top: 2rem;
        letter-spacing: 0.5px;
        height: 80%;
    }

    img {
        width: 50px;
        vertical-align: middle;
        border-style: none;
        border-radius: 100%;
    }

    /* Styling the msg-header container */
    .msg-header {
        border: 1px solid #ccc;
        width: 100%;
        height: 10%;
        border-bottom: none;
        display: inline-block;
        background-color: #efefef;
        margin: 0;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
    }

    /* Styling the profile picture */
    .msgimg {
        margin-left: 2%;
        float: left;
    }

    .container1 {
        width: 270px;
        height: auto;
        float: left;
        margin: 0;
    }

    /* styling user-name */
    .active {
        width: 150px;
        float: left;
        /* Bunu kaldırmanız gerekebilir, flexbox ile uyumlu çalışmaz */
        display: flex;
        align-items: center;
        /* Dikey ortalama */
        justify-content: center;
        /* Yatay ortalama */
        color: black;
        font-weight: bold;
        margin: 10px 0 0 10px;
        height: 10%;
        /* Yükseklik belirlenmişse buna göre ortalanır */
    }


    /* Styling the inbox */
    .chat-page {
        padding: 0 0 50px 0;
    }

    .msg-inbox {
        border: 1px solid #ccc;
        overflow: hidden;
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
    }


    .chats {
        min-height: 40vh;
        padding: 30px 15px 0 25px;
    }

    .msg-page {
        max-height: 500px;
        overflow-y: auto;
    }

    /* Styling the msg-bottom container */
    .msg-bottom {
        border-top: 1px solid #ccc;
        position: relative;
        height: 11%;
        background-color: rgb(239 239 239);
    }

    /* Styling the input field */
    .input-group {
        float: right;
        margin-top: 13px;
        margin-right: 20px;
        outline: none !important;
        border-radius: 20px;
        width: 61% !important;
        background-color: #fff;
        position: relative;
        display: flex;
        flex-wrap: wrap;
        align-items: stretch;
    }

    .input-group>.form-control {
        position: relative;
        flex: 1 1 auto;
        width: 1%;
        margin-bottom: 0;
    }

    .form-control {
        border: none !important;
        border-radius: 20px !important;
        display: block;
        height: calc(2.25rem + 2px);
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .input-group-text {
        background: transparent !important;
        border: none !important;
        display: flex;
        align-items: center;
        padding: 0.375rem 0.75rem;
        margin-bottom: 0;
        font-size: 1.5rem;
        font-weight: b;
        line-height: 1.5;
        color: #495057;
        text-align: center;
        white-space: nowrap;
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        font-weight: bold !important;
        cursor: pointer;
    }

    input:focus {
        outline: none;
        border: none !important;
        box-shadow: none !important;
    }

    .send-icon {
        font-weight: bold !important;
    }

    /* Styling the avatar  */
    received-chats-img {
        display: inline-block;
        width: 50px;
        float: left;
    }

    .received-msg {
        display: inline-block;
        padding: 0 0 0 10px;
        vertical-align: top;
        width: 92%;
    }

    .received-msg-inbox {
        width: 57%;
    }

    .received-msg-inbox p {
        background: #efefef none repeat scroll 0 0;
        border-radius: 10px;
        color: #646464;
        font-size: 14px;
        margin-left: 1rem;
        padding: 1rem;
        width: 100%;
        box-shadow: rgb(0 0 0 / 25%) 0px 5px 5px 2px;
    }

    p {
        overflow-wrap: break-word;
    }

    /* Styling the msg-sent time  */
    .time {
        color: #777;
        display: block;
        font-size: 12px;
        margin: 8px 0 0;
    }

    .outgoing-chats {
        overflow: hidden;
        margin: 26px 20px;
    }

    .outgoing-chats-msg p {
        background-color: #3a12ff;
        background-image: linear-gradient(45deg, #ee087f 0%, #DD2A7B 25%, #9858ac 50%, #8134AF 75%, #515BD4 100%);
        color: #fff;
        border-radius: 10px;
        font-size: 14px;
        color: #fff;
        padding: 5px 10px 5px 12px;
        width: 100%;
        padding: 1rem;
        box-shadow: rgb(0 0 0 / 25%) 0px 2px 5px 2px;
    }

    .outgoing-chats-msg {
        float: right;
        width: 46%;
    }

    /* Styling the avatar */
    .outgoing-chats-img {
        display: inline-block;
        width: 50px;
        float: right;
        margin-right: 1rem;
    }

    @media only screen and (max-device-width: 850px) {

        *,
        .time {
            font-size: 28px;
        }

        img {
            width: 65px;
        }

        .msg-header {
            height: 5%;
        }

        .msg-page {
            max-height: none;
        }

        .received-msg-inbox p {
            font-size: 28px;
        }

        .outgoing-chats-msg p {
            font-size: 28px;
        }
    }

    @media only screen and (max-device-width: 450px) {

        *,
        .time {
            font-size: 28px;
        }

        img {
            width: 65px;
        }

        .msg-header {
            height: 5%;
        }

        .msg-page {
            max-height: none;
        }

        .received-msg-inbox p {
            font-size: 28px;
        }

        .outgoing-chats-msg p {
            font-size: 28px;
        }
    }
</style>
<div class="wrapper bg--white">
    <!-- HEADER-AREA START -->
    <?php require_once 'inc/menu.php'; ?>
    <!-- HEADER-AREA END -->

    <div class="container">
        
        <div class="msg-header">
        <div class="container1">
        <img src="<?php echo site . "/uploads/customer/" . $alici['bayilogo']; ?>" class="msgimg" />
          <div class="active" style="display: flex; align-items: center;justify-content: center;">
          <p><?php echo htmlspecialchars($alici_adi); ?>#<?php echo htmlspecialchars($alici['bayikodu']) ?></p>
          </div>
        </div>
      </div>
        <!-- Chat mesajları -->
        <div class="chat-page">
            <form action="" method="POST">
                <div class="msg-inbox">
                    <div class="chats">
                        <div class="msg-page">
                            <?php foreach ($mesajlar as $mesaj): ?>
                                <?php if ($mesaj['gonderen_id'] == $gonderen_id): ?>
                                    <div class="outgoing-chats">
                                        <div class="outgoing-chats-msg">
                                            <p><?php echo htmlspecialchars($mesaj['mesajicerik']); ?></p>
                                            <span class="time"><?php echo date("H:i | d M", strtotime($mesaj['mesajtarih'])); ?></span>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="received-chats">
                                        <div class="received-msg">
                                            <div class="received-msg-inbox">
                                                <p><?php echo htmlspecialchars($mesaj['mesajicerik']); ?></p>
                                                <span class="time"><?php echo date("H:i | d M", strtotime($mesaj['mesajtarih'])); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="msg-bottom">
                        <div class="input-group">
                            <input type="text" name="mesajicerik" class="form-control" placeholder="Mesajınızı yazınız...." />
                            <span class="input-group-text send-icon">
                                <button name="mesajgonder"><i class="bi bi-send"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<?php require_once 'inc/footer.php'; ?>