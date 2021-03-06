<?php

namespace App\Admin\Controllers;

abstract class Constant
{
    const PAGE_STATUS = array(-1 => 'Xoá', 0 => 'Đã tạo', 1 => "Đã duyệt");
    const TELCO = array(0 => 'Viettel', 1 => "Vinafone", 2 => "Mobifone", 3 => "Khác");
    const BLOCK = array(
        0 => 'N02 T3', 1 => "N03 T3-T4", 2 => "N03 T1", 3 => "N01 T4", 4 => "N02 T1", 5 => "N03 T2", 6 => "N01 T1",
        7 => "N04 AA-CC", 8 => "N01 T5", 9 => "N02 T2", 10 => "N01 T8", 12 => "N03 T3", 13 => "N01 T2", 14 => "N01 T3",
        15 => "Toà 789",
        16 => "Xuân La",
        17 => "Xuân Đỉnh",
        18 => "Xuân Tảo",
        100 => "Khác"
    );
    const CUSTOMER_STATUS = array(
        0 => 'Chưa liên hệ', 1 => "Chưa có nhu cầu", 2 => "Đã di chuyển", 3 => "Đang hẹn lên",
        6 => "Đang tập chỗ khác", 7 => "Đang chăm sóc", 
        8 => "Đã mua", 100 => "Khác"
    );
    const SOURCE = array(
        0 => 'Excel', 1 => 'Facebook', 2 => 'Page', 3 => 'Voucher', 4 => 'BR', 5 => 'Miss Sale',
        6 => 'Hội viên', 7 => "Hotline", 8 => 'Khách Cali', 9 => 'Club', 10=>'Hoàng Hoa Thám', 100 => "Khác"
    );
    const SHOW_STATUS = array(0 => 'Ẩn', 1 => 'Hiện');
    const FAVORITE = array(0 => 'Không', 1 => 'Có');
    const SWITCH_STATE = array(
        'on'  => ['value' => 1, 'text' => '&nbsp;Hiện  ', 'color' => 'success'],
        'off' => ['value' => 0, 'text' => '&nbsp;&nbsp;Ẩn&nbsp;&nbsp;', 'color' => 'danger'],
    );
    const CONTRACT_TYPE = array(0 => 'PT', 1 => 'Hội viên', 4 => "Bơi cơ bản", 5 => "PT bơi");
    const CONTRACT_TIME = array(0 => 'Full time', 1 => 'Off peak');
    const CONTRACT_LENGTH = array(0 => '1 Tháng', 1 => '3 Tháng', 2 => '6 Tháng', 3 => '1 Năm', 4 => '2 Năm', 5 => '3 Năm', 6 => '5 Năm', 7 => '10 Năm');
    const CONTRACT_PLACE = array(0 => 'N02-T3', 1 => 'N03-T4');
    const CONTRACT_SERVICE = array(0 => 'Swimming', 1 => 'Gym', 2 => 'Yoga + GroupX');
    const PT_CATEGORY = array(0 => 'Giãn cơ', 1 => 'Gym', 2 => 'Kick fit', 10 => 'Khác');

    const BILL_TYPE = array(0 => 'PT', 1 => 'Hội viên', 2 => "Gia hạn", 3 => 'Chuyển nhượng', 4 => "Bơi cơ bản", 5 => "PT bơi",
     6 => "Nâng câp", 7 => "Bảo lưu", 8 => "Làm lại thẻ");
    const PT_CONTRACT_TYPE = array(0 => 'Dp', 1 => 'Mvp');
    const APP_TYPE = array(0 => 'Lịch hẹn', 1 => 'Show');

    const YES_NO_QUESTION = array(0 => "No", 1 => "Yes");

    const HOW_KNOWN_US = array(
        0 => 'Bạn bè ', 1 => 'Hội viên cũ', 2 => 'Tài khoản liên kết', 3 => 'Bảng hiệu', 4 => 'tiếp thị từ xa',
        5 => 'Báo, tạp chí', 6 => 'Tờ rơi', 7 => 'ti vi', 8 => 'trang web'
    );

    const GFP_TARGET_VALUE = array(
        0 => 'Tăng cân', 1 => 'Giảm cân', 2 => 'Tăng cường sức bền và dẻo dai', 3 => 'Tăng cường sinh lý',
        4 => 'Tăng cường khả năng sinh sản', 5 => 'Cải thiện hệ tiêu hoá'
    );

    const EXP_TYPE = array(0 => "Thu", 1 => "Chi");
    const IN_TYPE = array(0 => "Vé lẻ", 1 => "Nước");
    const PAYMENT_TYPE = array(0 => "Chuyển khoản", 1 => "POS");
    const CUSTOMER_SOURCE = array(0 => 'Data', 1 => 'Page-Marketing', 2 => 'Voucher', 3 => "Renew", 4=> "Br");

    const REPORT_TYPE = array(1 => "Ngày", 2 => "Tháng");
}
