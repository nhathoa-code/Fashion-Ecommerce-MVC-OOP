<?php
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/database.php';
class Account extends Database
{
    protected $table = "account";
    public $token, $email, $password, $is_active, $role, $account_info, $new_pass, $re_new_pass, $old_pass, $id, $username, $fullname, $phone, $address, $account_id, $save_to_deli_info;
    public function init()
    {
        $action = "";
        foreach ($_POST as $key => $value) {
            if (substr($key, 0, 6) == "submit") {
                $last_underscore = strrpos($key, '_');
                $action = substr($key, strlen('submit_'), $last_underscore - strlen('submit_'));
                break;
            }
        }
        switch ($action) {
            case "add_account":
                global $ROOT_URL;
                $data_array = ["email"];
                $this->email = $_POST['email'];
                $this->password = $_POST['password'];
                $retype_password = $_POST['retype_password'];
                foreach ($data_array as $item) {
                    $_SESSION['data'][$item] = $_POST[$item];
                }
                if ($this->email === "") {
                    $_SESSION["error"]["email"] = "Email không được để trống";
                    header("location:" . $_SESSION['url']);
                    break;
                } else if ($this->account_check_email()) {
                    $_SESSION["error"]["email"] = "Email đã tồn tại";
                    header("location:" . $_SESSION['url']);
                    break;
                } else if ($this->password === "") {
                    $_SESSION["error"]["password"] = "Mật khẩu không được để trống";
                    header("location:" . $_SESSION['url']);
                    break;
                } else if ($this->password != $retype_password) {
                    $_SESSION["error"]["retype_password"] = "Mật khẩu nhập lại không đúng";
                    header("location:" . $_SESSION['url']);
                    break;
                }
                $this->password = password_hash($this->password, PASSWORD_DEFAULT);
                $this->is_active = 0;
                $this->role = 0;
                $this->token = bin2hex(random_bytes(16));
                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'nhathoa528@gmail.com';
                    $mail->Password   = 'qjdhwpgskgthqjof';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = 465;
                    $mail->CharSet = 'utf-8';

                    //Recipients
                    $mail->setFrom('nhathoa528@gmail.com');
                    $mail->addAddress($this->email);

                    //Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Đường dẫn kích hoạt tài khoản';
                    $mail->Body    = "<a href='http://localhost{$ROOT_URL}/kich-hoat?token={$this->token}'>Link kích hoạt</a>";
                    $mail->send();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                unset($_SESSION['error'], $_SESSION['data']);
                $_SESSION['message'] = "Đăng ký thành công,đường dẫn kích hoạt đã được gửi đến email";
                header("location:" . $_SESSION['url']);
                $this->account_insert();
                break;
            case "account_login":
                global $ROOT_URL;
                $data_array = ["email"];
                foreach ($data_array as $item) {
                    $_SESSION['data'][$item] = $_POST[$item];
                }
                $this->email = $_POST['email'];
                $this->password = $_POST['password'];
                if (!$this->check_email()) {
                    $_SESSION['error']['email'] = "Email không tồn tại";
                    header("location:$ROOT_URL/sign-in");
                    break;
                } else {
                    $this->account_info = $this->check_email()[0];
                    if (!password_verify($this->password, $this->account_info['password'])) {
                        $_SESSION['error']['password'] = "Mật khẩu không hợp lệ";
                        header("location:$ROOT_URL/sign-in");
                        break;
                    } else if ($this->account_info['is_active'] !== 1) {
                        $_SESSION['error']['active'] = "Tài khoản chưa được kích hoạt";
                        header("location:$ROOT_URL/sign-in");
                        break;
                    }
                    $_SESSION['account'] = $this->account_info;
                    unset($_SESSION['data']);
                    header("location:" . $_SESSION['url']);
                }
                break;
            case "change_pass":
                $this->new_pass = $_POST['new_pass'];
                $this->re_new_pass = $_POST['re_new_pass'];
                $this->old_pass = $_POST['old_pass'];
                if (!password_verify($this->old_pass, $_SESSION['account']['password'])) {
                    echo json_encode(array("error_old_pass" => "Mật khẩu cũ không đúng"));
                    break;
                }
                if ($this->new_pass === "") {
                    echo json_encode(array("error_new_pass" => "Mật khẩu mới không được để trống"));
                    break;
                }
                if ($this->new_pass !== $this->re_new_pass) {
                    echo json_encode(array("error_re_new_pass" => "Mật khẩu mới nhập lại không đúng"));
                    break;
                }
                $this->id = $_SESSION['account']['id'];
                $this->password = password_hash($this->new_pass, PASSWORD_DEFAULT);
                $_SESSION['account']['password'] = $this->password;
                $this->update_pass();
                echo json_encode(array("success" => true));
                break;
            case "forgot_password":
                $data_array = ["email"];
                foreach ($data_array as $item) {
                    $_SESSION['data'][$item] = $_POST[$item];
                }
                $this->email = $_POST['email'];
                if (!$this->account_check_email()) {
                    $_SESSION["error"]["email"] = "Email không tồn tại";
                    header("location:" . $_SESSION['url']);
                    break;
                }
                $sql = "UPDATE account SET token = ? WHERE email = ?";
                $token = bin2hex(random_bytes(16));
                $this->pdo_execute($sql, $token, $this->email);
                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'nhathoa528@gmail.com';
                    $mail->Password   = 'qjdhwpgskgthqjof';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = 465;
                    $mail->CharSet = 'utf-8';

                    //Recipients
                    $mail->setFrom('nhathoa528@gmail.com');
                    $mail->addAddress($this->email);

                    //Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Đường dẫn lấy lại mật khẩu';
                    $mail->Body    = "<a href='http://localhost/ecommerce/retrieve-password?token={$token}'>Lấy lại mật khẩu</a>";
                    $mail->send();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                unset($_SESSION['error'], $_SESSION['data']);
                $_SESSION['message'] = "Đường dẫn lấy lại mật khẩu đã được gửi đến email";
                header("location:" . $_SESSION['url']);
                break;
            case "retrieve_password":
                $pass = $_POST['pass'];
                $retype_pass = $_POST['retype_pass'];
                if (empty($pass)) {
                    $_SESSION["error"]["pass"] = "Không được để trống !";
                    header("location:" . $_SESSION['url']);
                    break;
                }
                if ($pass !== $retype_pass) {
                    $_SESSION["error"]["retype_pass"] = "Nhập lại mật khẩu không đúng !";
                    header("location:" . $_SESSION['url']);
                    break;
                }
                global $ROOT_URL;
                $sql = "UPDATE account SET password = ?,token = ? WHERE token  = ?";
                $this->pdo_execute($sql, password_hash($pass, PASSWORD_DEFAULT), null, $_POST['token']);
                header("location:$ROOT_URL/retrieve-success");
                break;
            case "update_profile":
                $this->username = $_POST['username'];
                $this->fullname = $_POST['fullname'];
                $this->email = $_POST['email'];
                $this->phone = $_POST['phone'];
                $this->address = $_POST['address'];
                $this->account_id = $_SESSION['account']['id'];
                $this->save_to_deli_info = $_POST['save_to_deli_info'];
                $this->table = "profile";
                if ($this->profile()) {
                    $this->update_profile();
                } else {
                    $this->add_profile();
                }
                echo "Cập nhật hồ sơ thành công";
                break;
            default:
                echo "Muốn làm gì ?";
        }
    }

    public function account_insert()
    {
        $sql = "INSERT INTO $this->table (email,password,role,is_active,token) values (?,?,?,?,?)";
        $this->pdo_execute($sql, $this->email, $this->password, $this->role, $this->is_active, $this->token);
    }

    public function account_check_email()
    {
        $sql = "SELECT * FROM $this->table WHERE email = ?";
        return $this->pdo_query($sql, $this->email);
    }


    public function account_login()
    {
        $sql = "SELECT * FROM $this->table WHERE email = ? AND password = ?";
        return $this->pdo_query_one($sql, $this->email, $this->password);
    }

    public function account_logout()
    {
        unset($_SESSION['customer']);
    }

    public function check_token()
    {
        $sql = "SELECT * FROM $this->table WHERE token = ?";
        return $this->pdo_query($sql, $this->token);
    }

    public function check_email()
    {
        $sql = "SELECT * FROM $this->table WHERE email = ?";
        return $this->pdo_query($sql, $this->email);
    }

    public function update_pass()
    {
        $sql = "UPDATE account SET password = ? WHERE id = ?";
        $this->pdo_execute($sql, $this->password, $this->id);
    }

    public function active_account()
    {
        $sql = "UPDATE $this->table SET is_active = ?,token = null WHERE token = ?";
        $this->pdo_execute($sql, 1, $this->token);
    }


    public function profile()
    {
        $sql = "SELECT * FROM $this->table WHERE account_id = ?";
        return $this->pdo_query($sql, $this->account_id);
    }

    public function update_profile()
    {
        $sql = "UPDATE $this->table SET username = ?, fullname = ?, email = ?, phone = ?, address = ?, save_to_deli_info = ? WHERE account_id = ?";
        $this->pdo_execute($sql, $this->username, $this->fullname, $this->email, $this->phone, $this->address, $this->save_to_deli_info ? 1 : 0, $this->account_id);
    }

    public function add_profile()
    {
        $sql = "INSERT INTO $this->table (username,fullname,email,phone,address,account_id,save_to_deli_info) values (?,?,?,?,?,?,?)";
        $this->pdo_execute($sql, $this->username, $this->fullname, $this->email, $this->phone, $this->address, $this->account_id, $this->save_to_deli_info ? 1 : 0);
    }
}

$customer = new account();
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $customer->init();
}
