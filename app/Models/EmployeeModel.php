<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table = 'sb_employee'; // Tên bảng
    protected $primaryKey = 'id';     // Khóa chính (nếu có)

    // Các cột trong bảng được phép thêm hoặc cập nhật
    protected $allowedFields = ['avatar','mobile', 'full_name','password','status','role_id', 'price_pay','shop_id','login_time','description'];


    /**
     * Hàm lấy thông tin nhân viên
     *
     * @param array
     * @return array các bản ghi có điều kiện thỏa mãn
     */
    
    public function getEmployeesByConditions(array $conditions = [])
    {
        $builder = $this->db->table($this->table);

        $builder->join('sb_role', 'sb_role.id = ' . $this->table . '.role_id', 'left'); // Join bảng sb_role vào bảng nhân viên
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
     * Hàm lấy thông tin nhân viên
     *
     * @param array
     * @return array các bản ghi có điều kiện thỏa mãn
     */
    
     public function getEmployeesList(array $conditions = [])
     {
         $builder = $this->db->table($this->table);
         $builder->select($this->table . '.*, sb_role.id as role_id,sb_role.title');
        $where = '';
         // Join bảng sb_role vào bảng nhân viên
         $builder->join('sb_role', 'sb_role.id = ' . $this->table . '.role_id', 'left');
     
         // Áp dụng các điều kiện nếu tồn tại
         if (!empty($conditions['shop_id'])) {
            $builder->where('shop_id', $conditions['shop_id']);
            $where .= ' shop_id = '.$conditions['shop_id'].'';
        }
         if (!empty($conditions['mobile'])) {
             $builder->where('mobile', $conditions['mobile']);
             $where .= ' AND mobile = '.$conditions['mobile'].'';
         }
     
         if (!empty($conditions['full_name'])) {
             $builder->like('full_name', $conditions['full_name']);
             $where .= ' AND full_name = '.$conditions['full_name'].'';
         }
     
         if (!empty($conditions['role_id'])) {
             $builder->where('role_id', $conditions['role_id']);
             $where .= ' AND role_id = '.$conditions['role_id'].'';
         }
         if (!empty($conditions['price_pay_min'])) {
             $builder->where('price_pay >=', $conditions['price_pay_min']);
         }
     
         if (!empty($conditions['price_pay_max'])) {
             $builder->where('price_pay <=', $conditions['price_pay_max']);
         }
     
         // Xác định số lượng bản ghi mỗi trang và trang hiện tại
         $limit = 20;
         $page = 1;
         if (!empty($conditions['page'])) {
             $page = $conditions['page'];
         }
     
         // Tính toán offset
         $offset = ($page - 1) * $limit;
     
         // Áp dụng limit và offset vào truy vấn
         $builder->limit($limit, $offset);
     
         // Lấy kết quả
         $results = $builder->get()->getResult();
       
    
         // Lấy tổng số bản ghi để tính toán phân trang
         $total = $this->db->table($this->table)
             ->join('sb_role', 'sb_role.id = ' . $this->table . '.role_id', 'left')
             ->where($where) // Áp dụng các điều kiện tìm kiếm giống như trên
             ->countAllResults();
         // Trả về kết quả phân trang
         return [
             'data' => $results,      // Dữ liệu nhân viên sau khi phân trang
             'total' => $total,       // Tổng số bản ghi
             'limit' => $limit,       // Số bản ghi mỗi trang
             'page' => $page,         // Trang hiện tại
             'total_pages' => ceil($total / $limit), // Tổng số trang
         ];
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
