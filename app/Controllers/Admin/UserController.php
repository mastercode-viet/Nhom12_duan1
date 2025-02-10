<?php
class UserController
{
    public function getAllUser() {
        $userModel = new UserModel();
        $listUser = $userModel->getAllData();
        include 'app/Views/Admin/user.php';
    }


    public function addUser() {
        include 'app/Views/Admin/add-user.php';
    }
    public function addPostUser() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $uploadDir = 'assets/Admin/upload/';
            $allowTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
            $deshPath = "";
            if (!empty($_FILES['image']['name'])) {
                $fileTmpPath = $_FILES['image']['tmp_name'];
                $fileType = mime_content_type($fileTmpPath);
                $fileName = basename($_FILES['image']['name']);
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $newFileName = uniqid() . "." . $fileExtension;

                if (in_array($fileType, $allowTypes)) {
                    $deshPath = $uploadDir . $newFileName;

                    if (!move_uploaded_file($fileTmpPath, $deshPath)) {
                        $_SESSION['message'] = "Không thể tải ảnh lên. Vui lòng thử lại.";
                        header("Location: " . BASE_URL . "?role=admin&act=add-user");
                        exit;
                    }
                } else {
                    $_SESSION['message'] = "Định dạng file không hợp lệ. Vui lòng chọn file ảnh.";
                    header("Location: " . BASE_URL . "?role=admin&act=add-user");
                    exit;
                }
            }

            $userModel = new UserModel();
            try {
                $message = $userModel->addUserToDB($deshPath);

                if ($message) {
                    $_SESSION['message'] = "Thêm mới thành công";
                    header("Location: " . BASE_URL . "?role=admin&act=all-user");
                    exit;
                } else {
                    throw new Exception("Thêm mới thất bại do lỗi cơ sở dữ liệu.");
                }
            } catch (Exception $e) {
                $_SESSION['message'] = $e->getMessage();
                header("Location: " . BASE_URL . "?role=admin&act=add-user");
                exit;
            }
        } else {
            $_SESSION['message'] = "Yêu cầu không hợp lệ.";
            header("Location: " . BASE_URL . "?role=admin&act=add-user");
            exit;
        }
    }
}