<?php
define('USER_AVATAR_PATH', 'users/');
define('LOGO_PATH', 'logo/');
define('BRAND_IMAGE_PATH', 'brand/');
define('PRODUCT_IMAGE_PATH', 'product/');


define('MAIL_MAILER', ['smtp', 'sendmail', 'mail']);
define('MAIL_ENCRYPTION', ['none' => 'null', 'tls' => 'tls', 'ssl' => 'ssl']);


define('DELETABLE', ['1' => 'No', '2' => 'Yes']);
define('PURCHASE_STATUS', ['1' => 'Recevied', '2' => 'Pertial','3'=> 'pending','4'=>'ordered']);
define('STATUS', ['Disabled', 'Active']);
define('GENDER', ['1' => 'Male', '2' => 'Female']);

define('TAX_METHOD', ['1' => 'exclusive', '2' => 'inclusive']);
define(
    'BARCODE_SYMBOLOGY',
    [
        'C128'  => 'CODE 128',
        'C39'   => 'CODE 39',
        'UPCA'  => 'UPC-A',
        'EAN8'  => 'EAN-8',
        'EAN13' => 'EAN-13',
    ]
);




if (!function_exists('permission')) {
    function permission(string $value)
    {
        if (collect(Illuminate\Support\Facades\Session::get('permission'))->contains($value)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('dropdown_action')) {
    function dropdown_action($action)
    {
        return '<div class="dropdown">
                <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-list text-light"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                ' . $action . '
                </div>
              </div>';
    }
}

if (!function_exists('table_checkbox')) {
    function table_checkbox($id)
    {
        return  '<div class="form-check">
                <input class="form-check-input select_data" type="checkbox" value="' . $id . '" id="checkbox' . $id . '" onchange="select_single_item(' . $id . ')">
                <label class="form-check-label" for="checkbox' . $id . '">
                
                </label>
              </div>';
    }
}

if (!function_exists('change_status')) {
    function change_status($status, $id, $permission)
    {
        return $status == 1 ? '<small style="cursor:pointer" class="badge badge-success ' . (permission($permission) ? 'change_status' : '') . '" data-status="0" data-id="' . $id . '">Active</small>'
            : '<small style="cursor:pointer" class="badge badge-danger ' . (permission($permission) ? 'change_status' : '') . '" data-status="1" data-id="' . $id . '" >Disable</small>';
    }
}

if (!function_exists('table_image')) {
    function table_image($image, $path, $name = null)
    {
        return $image ? "<img src='storage/" . $path . $image . "'alt='" . $name . "' style='width:50px'/>"
            : "<img src='images/male.png' alt='" . $name . "' style='width:50px' />";
    }
}
