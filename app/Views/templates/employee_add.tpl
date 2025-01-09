{block name='content'}
  <style>
   
  </style>
  <div class="be-contents">
    <div class="page-head">
      <h2 class="page-head-title">Thêm mới nhân viên</h2>
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb page-head-nav">
          <li class="breadcrumb-item">
            <a href="#">Trang chủ</a>
          </li>
          <li class="breadcrumb-item">
            <a href="employee">Nhân viên</a>
          </li>
        </ol>
      </nav>
    </div>
    <div class="main-content container-fluid">
      <div class="row">

        <div class="col-lg-12">
          <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">Thêm nhân viên vào shop
            </div>
            <div class="card-body">
              <form data-parsley-validate="" id="addForm" novalidate="" method="POST" action="employee/store">
                <div class="form-group row">
                  <label class="col-3 col-lg-2 col-form-label text-right" for="full_name">Ảnh đại diện</label>
                  <div class="col-9 col-lg-10 related_div">
                  <div class="avatarOver">
                   <img id="imagePreview" src="..\assets\img\avatar.png" title="ấn vào ảnh để đổi ảnh đại diện" alt="Ảnh hiển thị">
                    <input class="form-control" name="avatar" id="avatar" type="file" style="display:none">
                    <div class="icon-container showAvt">
                        <div class="icon"><span class="mdi mdi-camera-party-mode"></span></div><span class="icon-class"></span>
                      </div>
                  </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-3 col-lg-2 col-form-label text-right" for="full_name">Họ tên</label>
                  <div class="col-9 col-lg-10">
                    <input class="form-control" name="full_name" id="full_name" type="text" required=""
                      placeholder="Họ và tên nhân viên">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-3 col-lg-2 col-form-label text-right" for="mobile">Số điện thoại</label>
                  <div class="col-9 col-lg-10">
                    <input class="form-control" name="mobile" id="mobile" type="number" required=""
                      placeholder="Số điện thoại nhân viên">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-3 col-lg-2 col-form-label text-right" for="password">Mật khẩu truy cập</label>
                  <div class="col-9 col-lg-10">
                    <input class="form-control" name="password" id="password" type="password" required=""
                      placeholder="Password">
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
                      <a href="employee" class="btn btn-space btn-secondary">Quay lại danh sách</a>
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