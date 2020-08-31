
const csrf_token = $("meta[name='_token']").attr("content");
const route_name = $("meta[name='_route']").attr("content");

const loading = '<div class="row loading"><div class="col-xl-12"><i class="fa fa-spinner fa-spin"></i><br>Đang lấy dữ liệu</div></div>';

const language = {
    "paginate": {
        "first": "",
        "last": "",
        "previous": " ",
        "next": " ",
    },
    "emptyTable": "Không có dữ liệu",
    "info": "Hiển thị _START_ đến _END_ của _TOTAL_ bản ghi",
    "infoEmpty": "Không có bản ghi nào",
    "lengthMenu": "Hiển thị: _MENU_ bản ghi",
    "loadingRecords": "Đang tải...",
    "processing": "Đang lấy dữ liệu...",
    "search": "Tìm kiếm",
    "zeroRecords": "Không có bản ghi nào",
    "infoFiltered": "(tìm được trong _MAX_ bản ghi)"
};

(function (window, undefined) {
    'use strict';

    let list = $("#main-menu-navigation a");

    $.each(list, function(i, e) {
        let element = $(e);
        let route = element.attr("route-name");
        if (route_name === route) {
            element.parent().addClass("active");
        }
    });

    // preview image upload
    $("input[data-role='preview-image']").on("change", function () {
        $("#preview-image").html("");

        if (this.files) {
            for (let i = 0; i < this.files.length; i++) {
                let reader = new FileReader();

                reader.onload = function (e) {
                    $("#preview-image").append('<img src="' + e.target.result + '" alt="...">');
                }

                reader.readAsDataURL(this.files[i]); // convert to base64 string
            }
        }
    });

})(window);



// định dạng tiền tệ
function formatNumber(nStr, decSeperate = ",", groupSeperate = ",") {
    nStr += '';
    x = nStr.split(decSeperate);
    x1 = x[0];
    x2 = x.length > 1 ? ',' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + groupSeperate + '$2');
    }
    return x1 + x2;
}

// open loading
function loading_page(status) {
    if (status == 'show') {
        $('.loading_page').show();
    } else if (status == 'hide') {
        $('.loading_page').hide();
    }
}

function remove(url) {
    Swal.fire({
        title: 'Bạn có thật sự muốn xóa?',
        text: "Không thể hoàn tác.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Có',
        cancelButtonText: 'Không',
        confirmButtonClass: 'btn btn-primary',
        cancelButtonClass: 'btn btn-danger ml-1',
        buttonsStyling: false,
    }).then(function (result) {
        if (result.value) {
            location.href = url;
        }
    });
}

function error(text) {
    Swal.fire({
        title: "Lỗi!",
        text: text,
        type: "error",
        confirmButtonClass: 'btn btn-danger',
        buttonsStyling: false,
    });
}