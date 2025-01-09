{block name='content'} <style>
   
    </style>
    <div class="be-contents">
      <div class="page-head">
        <h2 class="page-head-title">Chỉnh sửa sản phẩm</h2>
        <nav aria-label="breadcrumb" role="navigation">
          <ol class="breadcrumb page-head-nav">
            <li class="breadcrumb-item">
              <a href="#">Trang chủ</a>
            </li>
            <li class="breadcrumb-item">
              <a href="product">Sản phẩm</a>
            </li>
          </ol>
        </nav>
      </div>
      <div class="main-content container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-border-color card-border-color-primary">
              <div class="card-header card-header-divider">Sản phẩm</div>
              <div class="card-body">
                <form data-parsley-validate="" id="addForm" novalidate="" method="POST" action="">
                <div class="form-group row">
                  <label class="col-3 col-lg-2 col-form-label text-right" for="full_name">Ảnh sản phẩm(nếu có)</label>
                  <div class="col-9 col-lg-10 related_div">
                  <div class="avatarOver">
                   <img id="imagePreview"  src="{if $product.image}..\public\{$product.image}{else}..\assets\img\product.jpg {/if}" title="ấn vào ảnh để đổi ảnh" alt="Ảnh hiển thị">
                    <input class="form-control" name="avatar" id="avatar" type="file" style="display:none">
                    <div class="icon-container showAvt">
                        <div class="icon"><span class="mdi mdi-camera-party-mode"></span></div><span class="icon-class"></span>
                      </div>
                  </div>
                  </div>
                </div>
                  <div class="form-group row">
                    <label class="col-3 col-lg-2 col-form-label text-right" for="product_name">Tên sản phẩm</label>
                    <div class="col-9 col-lg-4">
                      <input class="form-control" name="product_name" value="{$product.product_name}" id="product_name" type="text" placeholder="Nhập tên sản phẩm">
                      <input type="hidden" id="id" value="{$product.id}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-lg-2 col-form-label text-right" for="price">Giá bán</label>
                    <div class="col-9 col-lg-4">
                      <input style="width: 100%;" type="text" onkeyup="formatNumber(this)" maxlength="350" class="price form-control" value="{$product.price|number_format:0:" ,":","}" placeholder="Nhập giá bán của sản phẩm">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-lg-2 col-form-label text-right" for="inputWebSite">Đơn vị sản phẩm</label>
                    <div class="col-9 col-lg-4">
                    <select class="detail_product_unit form-control">
                    <option value="add" class="optionAdd">Thêm đơn vị mới</option>
                    <option value="" selected>Chọn đơn vị</option>
                        <option value="1" {if $product.unit == 1}selected{/if}>Kg</option>
                      <option value="2"  {if $product.unit == 2}selected{/if}>Chiếc</option> {if $listUnit} {foreach from=$listUnit item=item} <option value="{$item.id}"  {if $product.unit == $item.id}selected{/if}>{$item.title}</option> {/foreach} {/if}
                    </select>
                    </div>
                  </div>
                  <div class="form-group row">
                  <label class="col-3 col-lg-2 col-form-label text-right" for="">Trạng thái</label>
                  <div class="col-9 col-lg-4">
                    <select class="form-control" name="status" id="status">
                      <option value="1"  {if $product.status == 1}selected{/if}> Đang bán</option>
                      <option value="0"  {if $product.status == 0}selected{/if}> Ngừng bán</option>
                    </select>
                  </div>
                </div>
                  <div class="form-group row">
                    <label class="col-3 col-lg-2 col-form-label text-right" for="inputWebSite">Mô tả</label>
                    <div class="col-9 col-lg-10">
                      <textarea class="form-control" name="description" id="description">{$product.description}</textarea>
                    </div>
                  </div>
                  <div class="row pt-2 pt-sm-5 mt-1">
                    <div class="col-sm-6 pl-0">
                      <p class="text-right">
                        <button class="btn btn-space btn-primary saveEditproduct" type="button">Lưu</button>
                        <a href="product" class="btn btn-space btn-secondary">Quay lại danh sách</a>
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
    <div id="addOption" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        </div>
        <div class="modal-body">
          <lable>Nhập tên đơn vị mới</lable>
          <input class="form-control new_option" type="text" placeholder="Nhập tên đơn vị">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary add_new_option">Lưu</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Hủy bỏ</button>
        </div>
      </div>
  
    </div>
  </div>
    <script src="..\assets\js\product.js" type="text/javascript"></script>
    <script src="..\assets\js\income.js" type="text/javascript"></script>
 {/block}