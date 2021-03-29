<?php

namespace App\Admin\Controllers;

abstract class Constant
{
    const PAGE_STATUS = array(-1 => 'Xoá', 0 => 'Đã tạo', 1 => "Đã duyệt");
    const TELCO = array(0 => 'Viettel', 1 => "Vinafone", 2 => "Mobifone", 3 => "Khác");
    const BLOCK = array(
        0 => 'N02 T3', 1 => "N03 T3-T4", 2 => "N03 T1", 3 => "N01 T4", 4 => "N02 T1", 5 => "N03 T2", 6 => "N01 T1",
        7 => "N04 AA-CC", 8 => "N01 T5", 9 => "N02 T2", 10 => "N01 T8", 12 => "N03 T3", 13 => "N01 T2", 14 => "N01 T3",
        15 => "N01 T4", 100 => "Khác"
    );
    const CUSTOMER_STATUS = array(
        0 => 'Chưa liên hệ', 1 => "Chưa có nhu cầu", 2 => "Đã di chuyển", 3 => "Đang hẹn lên",
        4 => "Khách cũ", 6 => "Đang tập chỗ khác", 7 => "Đang chăm sóc", 100 => "Khác"
    );
    const SOURCE = array(
        0 => 'Excel', 1 => 'Facebook', 2 => 'Page', 3 => 'Voucher', 4 => 'BR', 5 => 'Miss Sale',
        6 => 'Hội viên', 7 => "Hotline", 8 => 'Khách Cali', 9 => 'Club', 100 => "Khác"
    );
    const SHOW_STATUS = array(0 => 'Ẩn', 1 => 'Hiện');
    const FAVORITE = array(0 => 'Không', 1 => 'Có');
    const SWITCH_STATE = array(
        'on'  => ['value' => 1, 'text' => '&nbsp;Hiện  ', 'color' => 'success'],
        'off' => ['value' => 0, 'text' => '&nbsp;&nbsp;Ẩn&nbsp;&nbsp;', 'color' => 'danger'],
    );
    const BANNER_POSITION = array(0 => 'Trái', 1 => 'Phải');
    const APP_TYPE = array(0 => 'Lịch hẹn', 1 => 'Show');
    const POST_CATEGORY = array(
        0 => 'Trang chủ', 1 => 'Điểm đến',
        2 => "Cảm hứng", 3 => "Sự kiện", 4 => "Tin tức", 5 => "Thư viện Media"
    );
    const POST_TYPE = array(
        0 => 'Di tích & Danh lam', 1 => 'Cơ quan hành chính',
        2 => "Khách sạn", 3 => "Nhà hàng quán ăn", 4 => "Trung tâm thương mại",
        5 => "Giải trí thư giãn", 6 => "Dịch vụ hỗ trợ"
    );
    const LOCATION_TYPE_ROUTE = array(
        "sightseeing" => 0, "office" => 1, "hotel" => 2,
        "restaurant" => 3, "mall" => 4, "relax" => 5, "support" => 6
    );
    const CATEGORY_ROUTE = array(
        "index" => 0, "feeling" => 2, "map" => 1,
        "event" => 3, "news" => 4
    );

    const YES_NO_QUESTION = array(0 => "No", 1 => "Yes");

    const HOW_KNOWN_US = array(
        0 => 'Bạn bè ', 1 => 'Hội viên cũ', 2 => 'Tài khoản liên kết', 3 => 'Bảng hiệu', 4 => 'tiếp thị từ xa',
        5 => 'Báo, tạp chí', 6 => 'Tờ rơi', 7 => 'ti vi', 8 => 'trang web'
    );

    const GFP_TARGET_VALUE = array(
        0 => 'Tăng cân', 1 => 'Giảm cân', 2 => 'Tăng cường sức bền và dẻo dai', 3 => 'Tăng cường sinh lý',
        4 => 'Tăng cường khả năng sinh sản', 5 => 'Cải thiện hệ tiêu hoá'
    );
}
