<?php

namespace App\Constants;

final class Fund
{
    const FUND_TYPE = [
        1 => 'Thu',
        2 => 'Chi',
    ];

    const FUND_STATUS = [
       0 => 'Chờ xác nhận',
       1 => 'Đã xác nhận',
    ];

    const FUND_OK = 1;
    const FUND_CONFIRM = 0;
}