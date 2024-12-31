{block name='content'}
    <style>
      .card-body {
        background: #fff;
      }
  
      .btn-twitter {
        background-color: #2fc664 !important;
      }
      .showAvt {
      cursor: pointer;
    }
  
      #table1_filter {
        margin-bottom: 15px;
      }
      .avatarOver {
        width: 10%;
      }
  
      #table1_filter input {
        width: auto;
        padding: 5px 10px;
        font-size: 14px;
        border-radius: 5px;
        border: 1px solid #ccc;
      }
      #imagePreview {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 100%;
        cursor: pointer;
      }
      .card-tables {
        text-align: right;
        margin-bottom: 10px;
      }
      .icon-container{
        position: absolute;
        top: 5px;
        left: 17px;
        border-radius: 100%;
        background-color: unset;
        display: none;
      }
     
      .related_div{
        position: relative;
      }
    </style>
    <div class="be-contents">
      <div class="page-head">
        <h2 class="page-head-title">Thêm mới phiếu nhập hàng</h2>
        <nav aria-label="breadcrumb" role="navigation">
          <ol class="breadcrumb page-head-nav">
            <li class="breadcrumb-item">
              <a href="#">Trang chủ</a>
            </li>
            <li class="breadcrumb-item">
              <a href="income">Nhập hàng</a>
            </li>
          </ol>
        </nav>
      </div>
      <div class="main-content container-fluid">
        <div class="row">
  
          <div class="col-lg-12">
            <div class="card card-border-color card-border-color-primary">
              <div class="card-header card-header-divider">Phiếu nhập
              </div>
              <div class="card-body">
                <form data-parsley-validate="" id="addForm" novalidate="" method="POST" action="employee/store">
                  
                  <div class="form-group row">
                    <label class="col-3 col-lg-2 col-form-label text-right" for="id_bill">Mã phiếu</label>
                    <div class="col-9 col-lg-10">
                      <input class="form-control" name="id_bill" id="id_bill" type="text" disabled
                        placeholder="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-lg-2 col-form-label text-right" for="mobile">Ngày nhập</label>
                    <div class="col-9 col-lg-10">
                    <div class="input-group date datetimepicker" data-date="2024-09-16T05:25:07Z" data-date-format="yyyy-mm-dd - HH:ii" data-link-field="dtp_input1">
                    <input class="form-control" size="16" type="text" value="" readonly="">
                    <div class="input-group-append">
                      <button class="btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></button>
                    </div>
                  </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-lg-2 col-form-label text-right" for="password">Hàng hóa</label>
                    <div class="col-9 col-lg-10">
                    <div id="div_goods">
                    <input type="hidden" name="attribute_config" id="attribute_config" value="">
                    <table id="tbl_config_question" celspacing = 0 celpadding = 0 class="table_custom">
                        <thead>
                            <tr>
                                <th width="10%">Tên hàng</th>
                                <th width="2%">Số lượng</th>
                                <th width="5%">Đơn vị</th>
                                <th width="10%">
                                    <span class="btn btn-success btn-sm btn-view" onclick="addRow($(this))">Thêm dòng</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bodySortable"> 
                        <tr>
                        <td width="10%">
                            <input style="width: 100%;" type="text" maxlength="350" class="sct_question" value="">
                        </td> 
                
                        <td width="2%">
                            <select style="width: 80%;height:25px;" class="scp_type" data-selected="">
                                <option value="text" >Text</option>
                                <option value="number">Số</option>
                            </select>
                        </td>
                        <td width="5%">
                            <select style="width: 80%;height:25px;" class="sct_create_rp" data-selected="no">
                                <option value="yes" >Có</option>
                                <option value="no" >Không</option>
                            </select>
                        </td>
                        <td>
                            <span style="background-color: rgb(239, 191, 128)" class="btn btn-sm btn-view" onclick="removeRow($(this))">Xóa dòng</span>
                        </td>
                    </tr>
                        </tbody>
                        <tfoot hidden>
                        <tr>
                            <td width="10%">
                                <input style="width: 100%;" type="text" maxlength="350" class="sct_question" value="">
                            </td> 
                    
                            <td width="2%">
                                <select style="width: 80%;height:25px;" class="scp_type" data-selected="">
                                    <option value="text" >Text</option>
                                    <option value="number" >Số</option>
                                </select>
                            </td>
                            <td width="5%">
                                <select style="width: 80%;height:25px;" class="sct_create_rp" data-selected="no">
                                    <option value="yes">Có</option>
                                    <option value="no" >Không</option>
                                </select>
                            </td>
                            <td>
                                <span style="background-color: rgb(239, 191, 128)" class="btn btn-sm btn-view" onclick="removeRow($(this))">Xóa dòng</span>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-lg-2 col-form-label text-right" for="role">Quyền</label>
                    <div class="col-9 col-lg-10">
                      <select class="form-control" name="role_id" id="role_id">
                        <option value="1"> Đồng chủ shop</option>
                        <option value="2" selected> Nhân viên</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-lg-2 col-form-label text-right" for="inputWebSite">Trạng thái</label>
                    <div class="col-9 col-lg-10">
                      <select class="form-control" name="status" id="status">
                        <option value="1"> Hoạt động</option>
                        <option value="0"> Tạm dừng</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-lg-2 col-form-label text-right" for="price_pay">Công/đơn</label>
                    <div class="col-9 col-lg-10">
                      <input class="form-control" onkeyup="formatNumber(this)" name="price_pay" value="0" id="price_pay"
                        type="text" placeholder="Công trả cho 1 đơn thành công">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-lg-2 col-form-label text-right" for="inputWebSite">Mô tả</label>
                    <div class="col-9 col-lg-10">
                      <textarea class="form-control" name="description" id="description"></textarea>
                    </div>
                  </div>
                  <div class="row pt-2 pt-sm-5 mt-1">
                    <div class="col-sm-6 pl-0">
                      <p class="text-right">
                        <button class="btn btn-space btn-primary saveEmp" type="button">Lưu</button>
                        <button class="btn btn-space btn-secondary">Hủy</button>
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
    <script src="..\assets\js\income.js" type="text/javascript"></script>
  {/block}
  
