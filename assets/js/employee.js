
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
        var avatar = $("#avatar")[0].files[0];   

        if (name === '') {
            notify('Tên không được để trống', 'error');
            return;
        } 
        if (name.length >= 100) {
            notify('Tên quá dài, vui lòng đặt lại', 'error');
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
        var formData = new FormData();
            formData.append('mobile', mobile);
            formData.append('password', password);
            formData.append('full_name', name);
            formData.append('status', status);
            formData.append('role_id', role);
            formData.append('description', description);
            formData.append('price_pay', price_pay);
            if (avatar) {
                formData.append('avatar', avatar);  // Thêm file avatar vào FormData
            }
        $.ajax({
            url: 'employee/store',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
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

    $(".showAvt").click(function() {
        $("#avatar").click();  // Kích hoạt ô input file
    });

    // Khi người dùng chọn ảnh
    $("#avatar").change(function(event) {
        var file = event.target.files[0]; // Lấy file được chọn
        if (file) {
            var reader = new FileReader(); // Tạo đối tượng FileReader
            reader.onload = function(e) {
                // Hiển thị ảnh lên thẻ img
                $("#imagePreview").attr("src", e.target.result);
            };
            reader.readAsDataURL(file); // Đọc file dưới dạng URL
        }
    });


    $('.saveEditEmp').on('click', function (e) {
        var mobile = $('#mobile').val();
        var role = $('#role_id').val();
        var name = $('#full_name').val();      
        var description = $('#description').val();      
        var status = $('#status').val();      
        var price_pay = $('#price_pay').val();   
        var avatar = $("#avatar")[0].files[0];   
        var id = $('#id').val();
        if (name === '') {
            notify('Tên không được để trống', 'error');
            return;
        } 
        if (name.length >= 100) {
            notify('Tên quá dài, vui lòng đặt lại', 'error');
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

        var formData = new FormData();
            formData.append('mobile', mobile);
            formData.append('full_name', name);
            formData.append('status', status);
            formData.append('role_id', role);
            formData.append('description', description);
            formData.append('price_pay', price_pay);
            formData.append('id', id);
            if (avatar) {
                formData.append('avatar', avatar);  // Thêm file avatar vào FormData
            }
        $.ajax({
            url: 'employee/update',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                // Kiểm tra phản hồi từ server
                if (response.success) {
                    notify('Cập nhật thành công!','success');
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

    $('.btnDelEpl').on('click', function (e) {
        if(confirm("Xác nhận xóa nhân viên này khỏi shop? Sau khi xóa toàn bộ dữ liệu của nhân viên này sẽ được giao lại cho tài khoản của chủ shop(trong trường hợp nhân viên tạm nghỉ, bạn có thể chỉnh sửa trạng thái về tạm dừng.)")){
            var id = $(this).attr('attr-id');
            $.ajax({
                url: 'employee/delete',
                type: 'POST',
                data: {
                    id:id
                },
                success: function (response) {
                    // Kiểm tra phản hồi từ server
                    if (response.success) {
                        notify('Xóa thành công!','success');
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
        }
        else{
            return false;
        }
    });

    $('.avatarOver').hover(
        function() {
          // Khi hover vào
          $('.icon-container').show();  // Hiển thị .icon-container
        }, 
        function() {
          // Khi rời khỏi
          $('.icon-container').hide();  // Ẩn .icon-container
        }
      );
}); 
