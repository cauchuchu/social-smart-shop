<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

class ShopModel extends Model
{
    protected $table = 'sb_shop'; // Tên bảng
    protected $primaryKey = 'id'; // Khóa chính

    // Các cột được phép thêm hoặc cập nhật
    protected $allowedFields = ['shop_name', 'package_id'];

    /**
     * Hàm thêm mới một shop
     *
     * @param array $data Dữ liệu của shop (bao gồm 'title' và 'packageid')
     * @return int|bool ID của shop mới tạo hoặc false nếu thất bại
     */
    public function createShop(array $data)
    {
        // Kiểm tra dữ liệu hợp lệ
        if ($this->insert($data)) {
            return $this->getInsertID(); // Lấy ID của bản ghi mới
        }
        return false;
    }


}