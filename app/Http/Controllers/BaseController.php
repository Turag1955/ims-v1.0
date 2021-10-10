<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected $output;
    protected $service;

    /**
     * @param $page_title
     * @param $sub_title
     * @param $page_icon
     */

    protected function setPageData($page_title, $sub_title, $page_icon)
    {
        view()->share([
            'page_title' => $page_title,
            'sub_title'  => $sub_title,
            'page_icon'  => $page_icon
        ]);
    }

    /**
     * @param $error_code
     * @param $message
     * @return errorpage
     */

    protected function showErrorPage($error_code = 404, $message = null)
    {
        $data['message'] = $message;
        return response()->view('errors.' . $error_code, $data, $error_code);
    }

    /**
     * @param $status
     * @param $message
     * @param $data
     * @param $response_code
     * @return response_json
     */

    protected function response_json($status = 'success', $message = null, $data = null, $response_code = 200)
    {
        return response()->json([
            'status'        => $status,
            'message'       => $message,
            'data'          => $data,
            'response_code' => $response_code,
        ]);
    }

    protected function unauthorized_access(){
       return redirect('unauthorized');
    }
}
