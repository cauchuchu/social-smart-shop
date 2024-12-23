
$(document).ready(function(){


});
function notify(msg,type) {
  $.notify(msg, type);
}
function formatNumber(inputSelector) {
  $(inputSelector).on('keyup', function() {
      // Lấy giá trị từ input và loại bỏ tất cả ký tự không phải số
      var value = $(this).val().replace(/[^\d]/g, '');

      // Định dạng lại số với dấu phẩy ở hàng nghìn
      var formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");

      // Cập nhật lại giá trị vào input
      $(this).val(formattedValue);
  });
}