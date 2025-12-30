<?php
// Include DAO
include_once '../dao/user-accounts.php';

// Lấy tất cả tài khoản người dùng
$users = user_account_select_all();
?>

<div class="container mt-5">
    <h2 class="mb-4">Quản lý Người Dùng</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo htmlspecialchars($_SESSION['message_type']); ?> alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_SESSION['message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php if (isset($_SESSION['error_detail']) && $_SESSION['message_type'] === 'danger'): ?>
                <p class="mt-2"><strong>Chi tiết lỗi:</strong> <?php echo htmlspecialchars($_SESSION['error_detail']); ?></p>
            <?php endif; ?>
        </div>
        <?php
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        unset($_SESSION['error_detail']);
        ?>
    <?php endif; ?>

    <button class="btn btn-primary mb-3" onclick="document.getElementById('addUserForm').style.display='block'; document.getElementById('userList').style.display='none';">
        <i class="fas fa-plus-circle me-2"></i> Thêm Người Dùng Mới
    </button>

    <div id="addUserForm" style="display:none;">
        <h3>Thêm Người Dùng Mới</h3>
        <form action="process_add_user.php" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="username" class="form-label" style="color: black;">Tên Đăng Nhập:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label" style="color: black;">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label" style="color: black;">Mật Khẩu:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="full_name" class="form-label" style="color: black;">Họ và Tên:</label>
                        <input type="text" class="form-control" id="full_name" name="full_name">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label" style="color: black;">Số Điện Thoại:</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="address" class="form-label" style="color: black;">Địa Chỉ:</label>
                        <input type="text" class="form-control" id="address" name="address">
                    </div>
                    <div class="mb-3">
                        <label for="profile_pic" class="form-label" style="color: black;">Ảnh Đại Diện:</label>
                        <input type="text" class="form-control" id="profile_pic" name="profile_pic">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Thêm Người Dùng</button>
            <button type="button" class="btn btn-secondary" onclick="document.getElementById('addUserForm').style.display='none'; document.getElementById('userList').style.display='block';">Hủy</button>
        </form>
    </div>

    <div id="userList">
        <h3>Danh Sách Người Dùng</h3>
        <?php if (!empty($users)): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Đăng Nhập</th>
                        <th>Email</th>
                        <th>Họ và Tên</th>
                        <th>Số Điện Thoại</th>
                        <th>Địa Chỉ</th>
                        <th>Ảnh Đại Diện</th>
                        <th>Ngày Tạo</th>
                        <th>Ngày Xác Minh Email</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['phone']); ?></td>
                            <td><?php echo htmlspecialchars($user['address']); ?></td>
                            <td><?php echo htmlspecialchars($user['profile_pic']); ?></td>
                            <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                            <td><?php echo htmlspecialchars($user['email_verified_at']); ?></td>
                            <td>
                                <a href="edit_user.php?id=<?php echo $user['user_id']; ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Sửa</a>
                                <button class="btn btn-sm btn-danger deleteUserBtn" data-user-id="<?php echo $user['user_id']; ?>">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Không có người dùng nào.</p>
        <?php endif; ?>
    </div>
    <form id="deleteUserForm" action="process_delete_user.php" method="post" style="display: none;">
        <input type="hidden" name="user_id_to_delete" id="user_id_to_delete">
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteUserButtons = document.querySelectorAll('.deleteUserBtn');
        const deleteUserForm = document.getElementById('deleteUserForm');
        const userIdToDeleteInput = document.getElementById('user_id_to_delete');

        deleteUserButtons.forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.dataset.userId;
                if (confirm(`Bạn có chắc chắn muốn xóa người dùng có ID ${userId} không?`)) {
                    userIdToDeleteInput.value = userId;
                    deleteUserForm.submit();
                }
            });
        });
    });
</script>