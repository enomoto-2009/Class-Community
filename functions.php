<?php //セッションの開始
    session_start();
    $url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["SCRIPT_NAME"];
    $url = preg_replace("#\/[a-zA-Z0-9\-_.]+\.php$#u", "/" ,$url);
    function get_db() {
        //db接続情報
        $db_name = "mysql:host=localhost; dbname=class_community;";
        $db_username = "root";
        $db_password = "";
        //db接続
        try {
            $db = new PDO($db_name, $db_username, $db_password);
        } catch ( PDOException $e) {
            //エラー処理
            $msg = $e->getMessage();
            echo "DB接続エラー__Error";
            echo $msg;
            exit;
        }
        return $db;
    }
    if(isset($_SESSION["id"])) {
    $student_id = $_SESSION["id"];
    //SQL文の定義
    $sql = "SELECT * FROM login WHERE id = :id";
    //SQLステートメントの準備
    $statement = get_db()->prepare($sql);
    $statement->bindValue(':id', $student_id);
    //SQL実行
    $statement->execute();
    //結果の取得
    $result = $statement->fetch();
    global $login_user;
    $login_user = $result;
    $login_user["password"] = "";
    }
    if(empty($_SESSION["id"]) && !strpos($_SERVER["PHP_SELF"],"index.php")) {    
        // header("Location:{$url}index.php");
        // exit;
    }elseif(isset($_SESSION["id"]) && empty($result["profile"]) && !strpos($_SERVER["PHP_SELF"],"self_introduction_edit.php")&& !strpos($_SERVER["PHP_SELF"],"logout.php")) {
        header("Location:{$url}self_introduction_edit.php");
        exit;
    }
    function sc_is_login(){
        $login = !empty($_SESSON["id"]);
        return $login;
    }

    function get_query(string $sql,array $datas=null,bool $all) {
        if(empty($datas)){
            $statement = get_db()->query($sql);
        }else{
            $statement = get_db()->prepare($sql);
            foreach($datas as $key=>$data){
                $statement->bindValue($key,$data,PDO::PARAM_STR);
            }
        }
        //SQL実行
        $statement->execute();
        if($all == true) {
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $result = $statement->fetch(PDO::FETCH_ASSOC);
        }
        return $result;
    }
// エスケープ処理
    function e(string $str, string $charset = "UTF-8"): string {
        return htmlspecialchars($str, ENT_QUOTES | ENT_HTML5, $charset, false);
    }
    ?>