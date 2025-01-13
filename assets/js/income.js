function addRow(_this) {
    let row = _this.closest("#tbl_config_detail").find("tfoot tr").clone();
    _this.closest("#tbl_config_detail").find("tbody").append(row);
    return row;
}

function removeRow(_this) {
    _this.closest("tr").remove();
}

$(document).ready(function () {
    // Định nghĩa datetimepicker
    $(".date_in").datetimepicker({
        autoclose: true,
        componentIcon: ".mdi.mdi-calendar",
        navIcons: { rightIcon: "mdi mdi-chevron-right", leftIcon: "mdi mdi-chevron-left" }
    });
    $("#from_date,#to_date").datetimepicker({
        autoclose:!0,componentIcon:".mdi.mdi-calendar",
        format:"dd/mm/yyyy",
        navIcons:{rightIcon:"mdi mdi-chevron-right",leftIcon:"mdi mdi-chevron-left"}});

    $('#in_by').select2();
 
    // Định nghĩa DataTable
    var table = $('#tableIncome').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "income/list",
            "type": "GET",
            "data": function(d) {
                d.start = d.start;
                d.length = d.length;
                d.draw = d.draw;
                d.from_date = $('#from_date').val();
                d.to_date = $('#to_date').val();
                d.in_by = $('#in_by_search').val();
            }
        },
        "columns": [
            {
                "data": null, 
                "render": function(data, type, row) {
                    return '<a href="income-detail?id=' + row.id + '"> '+row.id_bill+'</a>';
                }
            },
            { "data": "date_in" },
            {
                "data": "total", 
                "render": function(data, type, row) {
                    return data + " đ"; 
                }
            },
            { "data": "full_name" },
            {
                "data": null, 
                "render": function(data, type, row) {
                    return '<div class="d-flex"><div><a href="income-edit?id=' + row.id + '" class="btn btn-space btn-primary" type="button"> Sửa</a></div>' +
                           ' <div><button class="btn btn-space btn-danger btnDelIn" attr-id="' + row.id + '"><i class="icon icon-left mdi mdi-alert-circle"></i>Xóa</button></div></div>';
                }
            }
        ],
        "pageLength": 20 ,
        "language": {
            "search": "Tìm kiếm nhanh"
        },
        "lengthChange": false,
         "dom": '<"top"f>rt<"bottom"ilp><"clear">'
    });

    $('#searchBtn').on('click', function() {
        table.ajax.reload();
    });
    var currentSelect = '';


    $(document).on("change",".detail_product_unit",function() {
        if($(this).val() == 'add'){
            $('#addOption').modal({
                // backdrop: 'static',
                // keyboard: true, 
                show: true
        }); 
            currentSelect = $(this);
        }
    });

    $('#addOption').on('hidden.bs.modal', function () {
        currentSelect.val('1').trigger('change');
      });
    
    // Save Income
    $(".saveIncome").on("click", function (e) {
        var arr = [];
        var name_pr = "";
        var qty_pr = "";
        var unit_pr = "";
        $("#tbl_detail tr").each(function (index) {
            name_pr = $(this).find(".detail_product_name").val();
            qty_pr = $(this).find(".detail_product_qty").val();
            unit_pr = $(this).find(".detail_product_unit").val();
            var item = {
                name: name_pr,  
                qty: qty_pr,
                unit: unit_pr
            };
            if(name_pr){
                arr.push(item);
            }
        });

        var attr_cfg = {
            list_detail: arr,
        };
        var id_bill = $("#id_bill").val();
        var date_in = $(".date_in").val();
        var attribute_config = JSON.stringify(attr_cfg);
        var total_in_pay = $(".total_in_pay").val();
        var in_by = $("#in_by").val();
        var description = $("#description").val();

        if (date_in === '') {
            notify('Vui lòng chọn ngày nhập hàng', 'error');
            return;
        } 
        if (total_in_pay === '') {
            notify('Vui lòng nhập tiền hàng', 'error');
            return;
        } 
        $.ajax({
            url: "income/store",
            type: "POST",
            data: {
                id_bill: id_bill,
                date_in: date_in,
                detail_product: attribute_config,
                total_in: total_in_pay,
                in_by: in_by,
                description: description,
            },
            success: function (response) {
                if (response.success) {
                    notify("Tạo phiếu thành công!", "success");
                    window.location.href = "income";
                } else {
                    notify(response.message, "error");
                    return;
                }
            },
            error: function (xhr, status, error) {
                notify("Có lỗi trong quá trình xử lý, vui lòng thử lại sau!", "error");
                console.error(error);
                return;
            },
        });
    });

    // Save Edit Income
    $(".editIncome").on("click", function (e) {
        var arr = [];
        var name_pr = "";
        var qty_pr = "";
        var unit_pr = "";
        $("#tbl_detail tr").each(function (index) {
            name_pr = $(this).find(".detail_product_name").val();
            qty_pr = $(this).find(".detail_product_qty").val();
            unit_pr = $(this).find(".detail_product_unit").val();
            var item = {
                name: name_pr, 
                qty: qty_pr,
                unit: unit_pr
            };
            if(name_pr){
                arr.push(item);
            }
           
        });

        var attr_cfg = {
            list_detail: arr,
        };

        var id_bill = $("#id_bill").val();
        var date_in = $(".date_in").val();
        var attribute_config = JSON.stringify(attr_cfg);
        var total_in = $(".total_in_pay").val();
        var in_by = $("#in_by").val();
        var description = $("#description").val();
        var id = $("#id").val();

        if (date_in === '') {
            notify('Vui lòng chọn ngày nhập hàng', 'error');
            return;
        } 
        if (total_in === '') {
            notify('Vui lòng nhập tiền hàng', 'error');
            return;
        } 

        $.ajax({
            url: "income/update",
            type: "POST",
            data: {
                id_bill: id_bill,
                date_in: date_in,
                detail: attribute_config,
                total_in: total_in,
                in_by: in_by,
                description: description,
                id: id,
            },
            success: function (response) {
                if (response.success) {
                    notify("Cập nhật phiếu thành công!", "success");
                    window.location.href = "income";
                } else {
                    notify(response.message, "error");
                    return;
                }
            },
            error: function (xhr, status, error) {
                notify("Có lỗi trong quá trình xử lý, vui lòng thử lại sau!", "error");
                console.error(error);
                return;
            },
        });
    });

    // Delete Income
        $(document).on("click",".btnDelIn",function() {
        if (confirm("Xác nhận xóa phiếu nhập này?")) {
            var id = $(this).attr("attr-id");
            $.ajax({
                url: "income/delete",
                type: "POST",
                data: {
                    id: id,
                },
                success: function (response) {
                    if (response.success) {
                        notify("Xóa thành công!", "success");
                        window.location.href = "income";
                    } else {
                        notify(response.message, "error");
                        return;
                    }
                },
                error: function (xhr, status, error) {
                    notify("Có lỗi trong quá trình xử lý, vui lòng thử lại sau!", "error");
                    console.error(error);
                    return;
                },
            });
        }
    });

    $(".add_new_option").on("click", function (e) {
        var value = $(".new_option").val();

        if (value === '') {
            notify('Vui lòng nhập tên đơn vị', 'error');
            return;
        } 

        $.ajax({
            url: "shop/add_option",
            type: "POST",
            data: {
                value: value
            },
            success: function (response) {
                if (response.success) {
                    notify("Thêm đơn vị thành công!", "success");
                    // Thêm option vào select
                    var newOption = $("<option>", {
                        value: response.id,
                        text: value,
                        selected: true 
                    });
                    var newOptionNon = $("<option>", {
                        value: response.id,
                        text: value,
                        selected: false 
                    });

                    // Thêm option vào select
                    $(".detail_product_unit").not(currentSelect).append(newOptionNon);
                    currentSelect.append(newOption);
                    $('#addOption').modal('hide');
                    currentSelect = '';
                    } else {
                    notify(response.message, "error");
                    return;
                }
            },
            error: function (xhr, status, error) {
                notify("Có lỗi trong quá trình xử lý, vui lòng thử lại sau!", "error");
                $('#addOption').modal('hide');
                console.error(error);
                return;
            },
        });
    });
});
