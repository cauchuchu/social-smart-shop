
$(document).ready(function () {
    $('#table1').DataTable({
        "pageLength": 20  ,
        "language": {
            "search": "Tìm kiếm nhanh"
        },
        "lengthChange": false,
         "dom": '<"top"f>rt<"bottom"ilp><"clear">'
    });

    $('.saveEmp').on('click', function (e) {
        var mobile = $('#mobile').val();
        var password = $('#password').val();
        var role = $('#role_id').val();
        var name = $('#full_name').val();      
        var description = $('#description').val();      
        var status = $('#status').val();      
        var price_pay = $('#price_pay').val();      
        if (name === '') {
            notify('Tên không được để trống', 'error');
            return;
        } 
        if (mobile === '') {
            notify('Số điện thoại không được để trống', 'error');
            return;
        }
        if (!/^\d{10}$/.test(mobile)) { // Kiểm tra định dạng số điện thoại
            notify('Số điện thoại không hợp lệ', 'error');
            return;
        }
        if (password === '') {
            notify('Mật khẩu không được để trống', 'error');
            return;
        }
        if (role === '') {
            notify('Vui lòng chọn quyền', 'error');
            return;
        }

        $.ajax({
            url: 'employee/store',
            type: 'POST',
            data: {
                mobile: mobile,
                password: password,
                full_name: name,
                status: status,
                role_id: role,
                description: description,
                price_pay: price_pay,
            },
            success: function (response) {
                console.log(23);
                // Kiểm tra phản hồi từ server
                if (response.success) {
                    notify('Tạo thành công!','success');
                    // Thực hiện redirect hoặc hành động khác
                    window.location.href = 'employee';
                } else {
                    notify(response.message,'error');
                    return;
                }
            },
            error: function (xhr, status, error) {
                // Xử lý lỗi
                notify('Có lỗi trong quá trình xử lý, vui lòng thử lại sau!','error');
                console.error(error);
                return;
            }
        });
    }); 
}); 
