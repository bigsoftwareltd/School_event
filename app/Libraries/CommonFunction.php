<?php

namespace App\Libraries;

use App\EmailQueue;
use App\Templates;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CommonFunction
{
    public static function getUserId()
    {
        if (Auth::user()) {
            return Auth::user()->id;
        } else {
            return 'Invalid Login Id';
        }
    }
    public static function getProjectRootDirectory()
    {
//        $root_position = strrpos(base_path(), '\\');
//        dd(substr(base_path(), 0, $root_position));
//        return (substr(base_path(), 0, $root_position));
        return public_path();
    }
    public static function dateShow($date)
    {
        if(!empty($date)) {
            return date('m/d/Y', strtotime(trim($date)));
        }
        return '';
    }

    public static function dateStore($date)
    {
        return date('Y-m-d', strtotime(trim($date)));
    }
    public static function showErrorPublic($param, $msg = 'Sorry! Something went wrong! ')
    {
        $j = strpos($param, '(SQL:');
        if ($j > 15) {
            $param = substr($param, 8, $j - 9);
        }
        return $msg . $param;
    }
    public static function getImageFromURL($db_path, $local_path=null, $id=null, $width='100px', $height ='100px')
    {
        $file_path = (string)($local_path.$db_path);
//        dd(asset($file_path));
        if (is_file($file_path)) {
            return '<img class="img-thumbnail" src="'. asset($file_path) .'" alt="Something" style="width: '.$width.'; height: '.$height.';" id="'.$id.'" />';
        } else {
            return "<img class='img-thumbnail' src='" . asset('admin/img/no_image_found.png') . "' alt='Image not found' style='width: $width; height: $height;' id='$id'>";
        }
    }
    public static function getStatus($status) {
        if (!empty($status) && $status == 1) {
            $class = 'badge badge-success';
            $status = 'Active';
        } else {
            $class = 'badge badge-danger';
            $status = 'Inactive';
        }
        return '<span class="' . $class . '">' . $status . '</span>';
    }
    public static function sendEmailSMS($caption = '', $data = [], $receiverInfo = [])
    {
        try {
            $template = Templates::where('caption', $caption)->first();

            if ($caption == 'ACCOUNT_ACTIVATION') {
                $template->email_content = str_replace('{$password}', $data['user_password'],$template->email_content);
                $template->email_content = str_replace('{$baseUrl}', $data['base_url'],$template->email_content);
            }elseif ($caption == 'REJECT_USER') {
                $template->email_content = str_replace('{$rejectReason}', $data['reject_reason'],$template->email_content);
            } elseif ($caption == 'PASSWORD_RESET') {
                $template->email_content = str_replace('{$password}', $data['new_password'],$template->email_content);
            }

            $header = $template->email_subject;
            $param = $template->email_content;
            $emailQueueData = [];

            foreach ($receiverInfo as $receiver) {
                $emailQueue = [];
                $emailQueue['caption'] = $template->caption;

                if ($template->email_active_status == 1 && !empty(trim($receiver['user_email']))) {
                    $emailQueue['email_content'] = view("email.message", compact('header', 'param'))->render();
                    $emailQueue['email_to'] = $receiver['user_email'];
                    $emailQueue['email_cc'] = empty($template->email_cc) ? '' : $template->email_cc;
                    $emailQueue['email_subject'] = $header;
                    $emailQueue['attachment'] = isset($data['attachment']) ? $data['attachment'] : '';
                    //$emailQueue['attachment_certificate_name'] = isset($data['attachment_certificate_name']) ? $data['attachment_certificate_name'] : '';
                }

                if (!empty(trim($receiver['mobile_number'])) && $template->sms_active_status == 1) {
                    $emailQueue['sms_content'] = $template->sms_content;
                    $emailQueue['sms_to'] = $receiver['mobile_number'];
                }

                $emailQueue['created_at'] = date('Y-m-d H:i:s');
                $emailQueue['updated_at'] = date('Y-m-d H:i:s');

                $emailQueueData[] = $emailQueue;
            }

            EmailQueue::insert($emailQueueData);
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . ' [CM-1005]');
            return Redirect::back()->withInput();
        }
    }

}
