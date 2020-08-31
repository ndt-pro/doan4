
<div id="quickViewModal" class="modal">
    <div class="modal-content modal-md">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h3 id="title"></h3>
        </div>
        <form onsubmit="return quickView(this)" method="post">
            <input type="hidden" name="id" id="id">
            <div class="modal-body">
                <div class="row">
                    <div class="col-6 p-3">
                        <div class="gallery">
                            <div class="image-view">
                                <img src="" alt="" id="image">
                            </div>
                        </div>
                    </div>
                    <div class="col-6 p-3">
                        <div class="product-price">
                        </div>
                        <div class="product-description">
                        </div>
                        
                        <div class="product-option" id="select-color" style="display: none">
                            Chọn màu:
                            <div class="list-color">
                            </div>
                        </div>

                        <div class="product-option" id="select-size" style="display: none">
                            <p>Chọn kích cỡ:</p>
                            <select name="size" class="form-control form-md" id="list-size">
                            </select>
                        </div>

                        <div class="product-option">
                            <p>Số lượng:</p>
                            <input type="number" name="quantity" value="1" class="form-control form-sm" min="1" max="" id="select-quantity">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning" name="submit">Thêm vào giỏ</button>
                <a href="" class="btn btn-primary">Xem chi tiết</a>
            </div>
        </form>
    </div>
</div>