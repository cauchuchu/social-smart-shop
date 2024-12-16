<?php

namespace Config;

use CodeIgniter\Database\Config;

/**
 * Database Configuration
 */
class Database extends Config
{
    /**
     * The directory that holds the Migrations
     * and Seeds directories.
     *
     * @var string
     */
    public $filesPath = APPPATH . 'Database/';

    /**
     * Lets you choose which connection group to
     * use if no other is specified.
     *
     * @var string
     */
    public $defaultGroup = 'default';

    /**
     * The default database connection.
     *
     * @var array
     */
    public $default = [
        'DSN'      => '',              // Data Source Name (chỉ dùng khi không muốn cấu hình từng phần)
        'hostname' => 'localhost',     // Tên máy chủ database
        'username' => 'root',          // Tên người dùng database
        'password' => '',              // Mật khẩu của người dùng database
        'database' => 'dbs_socbay',              // Tên cơ sở dữ liệu
        'DBDriver' => 'MySQLi',        // Loại driver sử dụng (MySQLi, Postgre, SQLite, etc.)
        'DBPrefix' => '',              // Tiền tố bảng (nếu cần)
        'pConnect' => false,           // Kết nối liên tục (persistent connection)
        'DBDebug'  => (ENVIRONMENT == 'production'), // Debug mode
        'charset'  => 'utf8mb4',       // Mã hóa ký tự
        'DBCollat' => 'utf8mb4_general_ci', // Định dạng so sánh
        'swapPre'  => '',              // Tiền tố thay thế
        'encrypt'  => false,           // Sử dụng mã hóa kết nối
        'compress' => false,           // Nén kết nối
        'strictOn' => false,           // Strict mode
        'failover' => [],              // Dự phòng khi kết nối thất bại
        'port'     => 3306,            // Cổng kết nối (mặc định là 3306 cho MySQL)
    ];

    /**
     * This database connection is used when
     * running PHPUnit database tests.
     *
     * @var array
     */
    public $tests = [
        'DSN'      => '',
        'hostname' => '127.0.0.1',
        'username' => '',
        'password' => '',
        'database' => ':memory:',
        'DBDriver' => 'SQLite3',
        'DBPrefix' => 'db_',           // Tiền tố bảng cho test
        'pConnect' => false,
        'DBDebug'  => true,
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
    ];

    //--------------------------------------------------------------------

    /**
     * This method allows you to get the database configuration
     * group that is currently being used.
     *
     * @param string $group
     *
     * @return array
     */
    public function __construct()
    {
        parent::__construct();

        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }
    }
}
