<?php
require_once 'pdo.php';

// Thêm một tài khoản người dùng mới
function user_account_insert($username, $email, $password, $profile_pic, $email_verification_token) {
    $sql = "INSERT INTO user_accounts(username, email, password, profile_pic, email_verification_token) VALUES (?,?,?,?,?)";
    pdo_execute($sql, $username, $email, $password, $profile_pic, $email_verification_token);
}

// Xóa một hoặc nhiều tài khoản người dùng
function user_account_delete($id) {
    $sql = "DELETE FROM user_accounts WHERE user_id=?";
    if (is_array($id)) {
        foreach ($id as $ma) {
            pdo_execute($sql, $ma);
        }
    } else {
        pdo_execute($sql, $id);
    }
}

// Truy vấn tất cả các tài khoản người dùng
function user_account_select_all() {
    $sql = "SELECT * FROM user_accounts ORDER BY created_at DESC";
    return pdo_query($sql);
}

// Truy vấn một tài khoản người dùng theo ID
function user_account_select_by_id($id) {
    $sql = "SELECT * FROM user_accounts WHERE user_id=?";
    return pdo_query_one($sql, $id);
}

// Kiểm tra xem tài khoản người dùng có tồn tại không
function user_account_exist($id) {
    $sql = "SELECT count(*) FROM user_accounts WHERE user_id=?";
    return pdo_query_value($sql, $id) > 0;
}

// Truy vấn tài khoản người dùng theo email
function user_account_select_by_email($email) {
    $sql = "SELECT * FROM user_accounts WHERE email=?";
    return pdo_query_one($sql, $email);
}

function user_account_update($user_id,$username,$email,$full_name,$phone,$address,$profile_pic) {
    $sql = "UPDATE user_accounts SET username = ?, email = ?, full_name=?, phone=?, address=?, profile_pic = ?WHERE user_id=?";
    return pdo_execute($sql, $username,$email,$full_name,$phone,$address,$profile_pic, $user_id);
}
?>