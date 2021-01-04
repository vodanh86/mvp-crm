<?php

namespace App\Admin\Controllers;

abstract class Constant
{
    const PAGE_STATUS = array(-1 => 'Xoá', 0 => 'Đã tạo', 1 => "Đã duyệt");
    const TELCO = array( 0 => 'Viettel', 1 => "Vinafone", 2 => "Mobifone", 3 => "Khác");
    const BLOCK = array( 0 => 'N02 T3', 1 => "N03 T3-T4", 2 => "N03 T1", 3 => "N01 T4", 4 => "N02 T1", 5 => "N03 T2", 6 => "N01 T1",
7 => "N04 AA-CC", 8 => "N01 T5", 100=> "Khác");
    const CUSTOMER_STATUS = array( 0 => 'Chưa liên hệ', 1 => "Chưa có nhu cầu", 2 => "Đã di chuyển", 3 => "Đang hẹn lên",
    4 => "Đã mua", 6 => "Đang tập chỗ khác", 100 => "Khác");
    const SOURCE = array(0 => 'Excel', 1 => 'Facebook', 2 => 'Page', 3 => 'Voucher', 4 => 'BR', 5 => 'WI', 6 => 'Hội viên', 7 => "Hotline", 100 => "Khác");
    const SHOW_STATUS = array(0 => 'Ẩn', 1 => 'Hiện');
    const FAVORITE = array(0 => 'Không', 1 => 'Có');
    const SWITCH_STATE = array(
        'on'  => ['value' => 1, 'text' => '&nbsp;Hiện  ', 'color' => 'success'],
        'off' => ['value' => 0, 'text' => '&nbsp;&nbsp;Ẩn&nbsp;&nbsp;', 'color' => 'danger'],
    );
    const BANNER_POSITION = array(0 => 'Trái', 1 => 'Phải');
    const POST_CATEGORY = array(0 => 'Trang chủ', 1 => 'Điểm đến',
                            2 => "Cảm hứng", 3 => "Sự kiện", 4 => "Tin tức", 5 => "Thư viện Media");
    const POST_TYPE = array(0 => 'Di tích & Danh lam', 1 => 'Cơ quan hành chính',
                            2 => "Khách sạn", 3 => "Nhà hàng quán ăn", 4 => "Trung tâm thương mại",
                            5 => "Giải trí thư giãn", 6 => "Dịch vụ hỗ trợ");
    const LOCATION_TYPE_ROUTE = array("sightseeing" => 0, "office" => 1, "hotel" => 2,
                            "restaurant" => 3, "mall" => 4, "relax" => 5,"support" => 6);
    const CATEGORY_ROUTE = array("index" => 0, "feeling" => 2, "map" => 1,
                            "event" => 3, "news" => 4);
}
?>