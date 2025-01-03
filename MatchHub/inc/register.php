<?php 

require_once '../system/function.php';

if( @$_SESSION['login'] == @sha1(md5(IP().$bcode)) ){
    go(site);
}

if($_POST){

    $bname  = post('bname');
    $bmail  = post('bmail');
    $bpass  = post('bpass');
    $bpass2 = post('bpass2');
  

    $bcode  = uniqid();
    $crypto = sha1(md5($bpass));

    if(!$bname || !$bmail ||!$bpass || !$bpass2 ){

        echo 'empty';

    }else{
        if(!filter_var($bmail,FILTER_VALIDATE_EMAIL)){
            echo 'format';
        }else{

            if($bpass != $bpass2){
                echo 'match';
            }else{

                $already = $db->prepare("SELECT bayimail FROM bayiler WHERE bayimail=:b");
                $already->execute([':b'=> $bmail]);
                if($already->rowCount()){
                    echo 'already';
                }else{

                    $result = $db->prepare("INSERT INTO bayiler SET
                        bayikodu    =:bcode,
                        bayiadi     =:bname,
                        bayimail    =:bmail,
                        bayisifre   =:bpass
                    ");

                    $result->execute([
                        ':bcode' => $bcode,
                        ':bname' => $bname,
                        ':bmail' => $bmail,
                        ':bpass' => $crypto
                    ]);

                    if($result->rowCount()){

                        require_once 'class.phpmailer.php';
                        require_once 'class.smtp.php';
        
                        $mail = new PHPMailer();
                        $mail->Host       = $arow->smtphost;
                        $mail->Port       = $arow->smtpport;
                        $mail->SMTPSecure = $arow->smtpsec;
                        $mail->Username   = $arow->smtpmail;
                        $mail->Password   = $arow->smtpsifre;
                        $mail->SMTPAuth   = true;
                        $mail->IsSMTP();
                        $mail->AddAddress($arow->smtpkime);
        
                        $mail->From       = $arow->smtpmail;
                        $mail->FromName   = "MatchHub";
                        $mail->CharSet    = 'UTF-8';
                        $mail->Subject    = "Yeni Kullanıcı Kaydı";
                        $mailcontent      = "
                        <p><b>Kullanıcı Kodu :</b>".$bcode."</p>
                        <p><b>Kullanıcı Adı:</b>".$bname."</p>
                        <p><b>Kullanıcı E-posta:</b>".$bmail."</p>
                        
                        <p><b>IP :</b>".IP()."</p>
                        ";
        
                        $mail->MsgHTML($mailcontent);
                        $mail->Send();

                        $log = $db->prepare("INSERT INTO bayilog SET
                            logbayi     =:b,
                            logip       =:i,
                            logaciklama =:a
                        ");
                        $log->execute([
                            ':b'   => $bcode,
                            ':i'   => IP(),
                            ':a'   => "Yeni kayıt oluşturuldu"
                        ]);
                        echo 'ok';
                    }else{
                        echo 'error';
                    }

                }

            }

        }
    }

}

?>