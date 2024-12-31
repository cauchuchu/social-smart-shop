{block name='content'}
    <style>
        .card-body {
            background: #fff;
        }

        .btn-twitter {
            background-color: #2fc664 !important;
        }

        #table1_filter {
            margin-bottom: 15px;
        }

        #table1_filter input {
            width: auto;
            padding: 5px 10px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .card-tables {
            text-align: right;
            margin-bottom: 10px;
        }
    </style>
    <div class="be-contents">
        <div class="page-head">
            <h2 class="page-head-title">Thông tin nhân viên</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item">
                        <a href="#">Trang chủ</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">Nhân viên</a>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="main-content container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-border-color card-border-color-primary">
                        <div class="card-header card-header-divider"> Thông tin {$employee.full_name} </div>
                        <div class="card-body">
                            <form data-parsley-validate="" id="addForm" novalidate="" method="POST"
                                action="employee/update">
                                <div class="form-group row">
                                    <label class="col-3 col-lg-2 col-form-label text-right" for="full_name">Họ tên</label>
                                    <div class="col-9 col-lg-10">
                                        <input class="form-control" name="full_name" id="full_name" type="text" required=""
                                            value="{$employee.full_name}" placeholder="Họ và tên nhân viên">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-lg-2 col-form-label text-right" for="mobile">Số điện
                                        thoại</label>
                                    <div class="col-9 col-lg-10">
                                        <input class="form-control" name="mobile" id="mobile" type="number"
                                            value="{$employee.mobile}" required="" placeholder="Số điện thoại nhân viên">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-lg-2 col-form-label text-right" for="role">Quyền</label>
                                    <div class="col-9 col-lg-10">
                                        <select class="form-control" name="role_id" id="role_id">
                                            <option value="1" {if $employee.role_id == 1}selected{/if}> Đồng chủ shop
                                            </option>
                                            <option value="2" {if $employee.role_id == 2}selected{/if}> Nhân viên</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-lg-2 col-form-label text-right" for="inputWebSite">Trạng
                                        thái</label>
                                    <div class="col-9 col-lg-10">
                                        <select class="form-control" name="status" id="status">
                                            <option value="1" {if $employee.status == 1}selected{/if}> Hoạt động</option>
                                            <option value="0" {if $employee.status == 0}selected{/if}> Tạm dừng</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-lg-2 col-form-label text-right" for="price_pay">Công/đơn</label>
                                    <div class="col-9 col-lg-10">
                                        <input class="form-control" onkeyup="formatNumber(this)"
                                            value="{$employee.price_pay|number_format:0:",":","}" name="price_pay" value="0" id="price_pay"
                                            type="text" placeholder="Công trả cho 1 đơn thành công">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-lg-2 col-form-label text-right" for="inputWebSite">Mô tả</label>
                                    <div class="col-9 col-lg-10">
                                        <textarea class="form-control" name="description"
                                            id="description" value="{$employee.description}">{$employee.description}</textarea>
                                    </div>
                                </div>
                                <div class="row pt-2 pt-sm-5 mt-1">
                                    <div class="col-sm-6 pl-0">
                                        <p class="text-right">
                                            <a href="employee" class="btn btn-space btn-secondary">Quay về danh sách</a>
                                        </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
{/block}