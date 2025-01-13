$(document).ready(function () {
    // Định nghĩa datetimepicker
    $(".date_in").datetimepicker({
        autoclose: true,
        componentIcon: ".mdi.mdi-calendar",
        navIcons: { rightIcon: "mdi mdi-chevron-right", leftIcon: "mdi mdi-chevron-left" }
    });
    $("#from_date,#to_date").datetimepicker({
        autoclose:!0,componentIcon:".mdi.mdi-calendar",
        format:"mm/dd/yyyy",
        navIcons:{rightIcon:"mdi mdi-chevron-right",leftIcon:"mdi mdi-chevron-left"}});

        var table = $('#tableCustomer').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "customer/list",
                "type": "GET",
                "data": function(d) {
                    d.start = d.start;
                    d.length = d.length;
                    d.draw = d.draw;
                    d.from_date = $('#from_date').val();
                    d.to_date = $('#to_date').val();
                }
            },
            "columns": [
                { "data": "customer_name" },
                { "data": "mobile" },
                {
                    "data": "address", 
                    "render": function(data, type, row) {
                        return '<a href="income-detail?id=' + row.id + '"> '+row.id_bill+'</a>';
                    }
                },
                { "data": "is_black" },
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
});