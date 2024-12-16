<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table = 'sb_employee'; // Tên bảng
    protected $primaryKey = 'id';     // Khóa chính (nếu có)

    // Các cột trong bảng được phép thêm hoặc cập nhật
    protected $allowedFields = ['mobile', 'full_name','password','role_id', 'price_pay','shop_id','login_time'];


    /**
     * Hàm lấy thông tin nhân viên
     *
     * @param array
     * @return array các bản ghi có điều kiện thỏa mãn
     */
    
    public function getEmployeesByConditions(array $conditions = [])
    {
        $builder = $this->db->table($this->table);

        // Áp dụng các điều kiện nếu tồn tại
        if (!empty($conditions['mobile'])) {
            $builder->where('mobile', $conditions['mobile']);
        }

        if (!empty($conditions['full_name'])) {
            $builder->like('full_name', $conditions['full_name']);
        }

        if (!empty($conditions['role_id'])) {
            $builder->where('role_id', $conditions['role_id']);
        }

        if (!empty($conditions['shop_id'])) {
            $builder->where('shop_id', $conditions['shop_id']);
        }

        if (!empty($conditions['price_pay_min'])) {
            $builder->where('price_pay >=', $conditions['price_pay_min']);
        }

        if (!empty($conditions['price_pay_max'])) {
            $builder->where('price_pay <=', $conditions['price_pay_max']);
        }

        // if (!empty($conditions['login_time_from'])) {
        //     $builder->where('login_time >=', $conditions['login_time_from']);
        // }

        // if (!empty($conditions['login_time_to'])) {
        //     $builder->where('login_time <=', $conditions['login_time_to']);
        // }

        return $builder->get()->getResultArray(); // Trả về mảng các bản ghi
    }

    /**
     * Hàm thêm mới nhân viên
     *
     * @param array $data Dữ liệu của nhân viên
     * @return int|bool Id nhân viên mới tạo hoặc false nếu thất bại
     */
    public function createEmployee(array $data)
    {
        // Kiểm tra dữ liệu hợp lệ
        if ($this->insert($data)) {
            return $this->getInsertID(); // Lấy ID của bản ghi mới
        }
        return false;
    }
}
