<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MailRequest;
use App\Http\Requests\GeneralRequest;
use App\Models\Sitting;
use App\Traits\uploadable;


class SittingController extends BaseController
{
    use uploadable;

    public function index()
    {
        if (permission('sitting-access')) {
            // dd(timezone_identifiers_list());
            $zones_array = [];
            $timestamp = time();
            foreach (timezone_identifiers_list() as $key => $zone) {
                date_default_timezone_set($zone);
                $zones_array[$key]['zone'] = $zone;
                $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
            }
            $this->setPageData('Sitting', 'Sitting', 'fas fa-th-list');
            return view('sitting.index', compact('zones_array'));
        } else {
            return $this->unauthorized_access();
        }
    }

    public function general_sitting(GeneralRequest $request)
    {
        if ($request->ajax()) {


            $collection = collect($request->validated())->except(['logo', 'favicon']);

            foreach ($collection->all() as $key => $value) {
                Sitting::set($key, $value);
                if ($key == 'timezone') {
                    if (!empty($value)) {
                        $this->changeEnvData(['APP_TIMEZONE' => $value]);
                    }
                }
            }
            if ($request->hasFile('logo')) {
                $logo =  $this->uploadfile($request->file('logo'), LOGO_PATH);
                if (!empty($request->old_logo_image)) {
                    $this->delete_file($request->old_logo_image, LOGO_PATH);
                }
                Sitting::set('logo', $logo);
            }

            if ($request->hasFile('favicon')) {
                $favicon =  $this->uploadfile($request->file('favicon'), LOGO_PATH);
                if (!empty($request->old_favicon_image)) {
                    $this->delete_file($request->old_favicon_image, LOGO_PATH);
                }
                Sitting::set('favicon', $favicon);
            }

            $output = ['status' => 'success', 'message' => 'Data Has Been Saved Successfully'];
            return response()->json($output);
        }
    }

    public function mail_sitting(MailRequest $request)
    {
        if ($request->ajax()) {
            $collection = collect($request->validated());
            foreach ($collection->all() as $key => $value) {
                Sitting::set($key, $value);
            }
            $this->changeEnvData([
                'MAIL_MAILER'       => $request->mail_mailer,
                'MAIL_HOST'         => $request->mail_host,
                'MAIL_PORT'         => $request->mail_port,
                'MAIL_USERNAME'     => $request->mail_username,
                'MAIL_PASSWORD'     => $request->mail_password,
                'MAIL_ENCRYPTION'   => $request->mail_encryption,
                'MAIL_FROM_NAME'    => $request->mail_from_name

            ]);
            $output = ['status' => 'success', 'message' => 'Data Has Been Saved Successfully'];
            return response()->json($output);
        }
    }

    protected function changeEnvData(array $data)
    {
        if (count($data) > 0) {
            $env = file_get_contents(base_path() . '/.env');
            $env = preg_split('/\s+/', $env);

            foreach ($data as $key => $value) {
                foreach ($env as $env_key => $env_value) {

                    $entry[] = explode("=", $env_value, 2);
                    if ($entry[$env_key][0] == $key) {
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        $env[$env_key] = $env_value;
                    }
                }
            }

            $env = implode("\n", $env);

            file_put_contents(base_path() . '/.env', $env);

            return true;
        } else {
            return false;
        }
    }
}
