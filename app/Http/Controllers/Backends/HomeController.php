<?php
namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Backends\Requests\SaveMenuRequest;
use App\Http\Controllers\Backends\Requests\UpdateSiteConfigRequest;
use App\Helper;
use App\SiteConfig;
use App\Page;
use App\PostCategory;
use App\Category;
use App\Menu;
use Auth;
use Validator;
use Cache;

class HomeController extends Controller{

    public function getAdminCp(){
        $orders = $totalOrders = $totalCustomers = $order_status = '';
        return view('backends.dashboard', compact('orders', 'totalOrders', 'totalCustomers', 'order_status'));
    }

    public function saveMenu(Request $request){
        $item = SiteConfig::where('key', '=', $request->key)->first();
        $item->value = $request->value;
        if($item->save()){
            Cache::forget('site_config');
            return \Response::json(array('status' => '200', 'message' => 'Cập nhật thông tin thành công!'));
        }else{
            return \Response::json(array('status' => '403', 'message' => 'Đã có lỗi xảy ra trong quá trình lưu dữ liệu!'));
        }
    }

    public function editInfo() {
        $logo            = SiteConfig::where('key', '=', 'logo')->value('value');
        $address         = SiteConfig::where('key', '=', 'address')->value('value');
        $email           = SiteConfig::where('key', '=', 'email')->value('value');
        $phone           = SiteConfig::where('key', '=', 'phone')->value('value');
        $phone_2         = SiteConfig::where('key', '=', 'phone_2')->value('value');
        $facebook        = SiteConfig::where('key', '=', 'facebook')->value('value');
        $youtube         = SiteConfig::where('key', '=', 'youtube')->value('value');
        $instagram       = SiteConfig::where('key', '=', 'instagram')->value('value');
        $lat             = SiteConfig::where('key', '=', 'lat')->value('value');
        $lng             = SiteConfig::where('key', '=', 'lng')->value('value');
        $seo_title       = SiteConfig::where('key', '=', 'seo_title')->value('value');
        $keywords        = SiteConfig::where('key', '=', 'keywords')->value('value');
        $seo_description = SiteConfig::where('key', '=', 'seo_description')->value('value');
        $payment_info    = SiteConfig::where('key', '=', 'payment_info')->value('value');


        return view('backends.config.general', compact('logo', 'email', 'address', 'phone', 'phone_2', 'facebook', 'youtube', 'instagram', 'lat', 'lng', 'seo_title', 'keywords', 'seo_description', 'payment_info') );
    }

    public function updateInfo(UpdateSiteConfigRequest $request) {
        Cache::forget('site_config');
        SiteConfig::where('key', '=', 'logo')->update(['value' => $request->logo]);
        SiteConfig::where('key', '=', 'email')->update(['value' => $request->email]);
        SiteConfig::where('key', '=', 'address')->update(['value' => $request->address]);
        SiteConfig::where('key', '=', 'phone')->update(['value' => $request->phone]);
        SiteConfig::where('key', '=', 'phone_2')->update(['value' => $request->phone_2]);
        SiteConfig::where('key', '=', 'facebook')->update(['value' => $request->facebook]);
        SiteConfig::where('key', '=', 'youtube')->update(['value' => $request->youtube]);
        SiteConfig::where('key', '=', 'instagram')->update(['value' => $request->instagram]);
        SiteConfig::where('key', '=', 'lat')->update(['value' => $request->lat]);
        SiteConfig::where('key', '=', 'lng')->update(['value' => $request->lng]);
        SiteConfig::where('key', '=', 'instagram')->update(['value' => $request->instagram]);
        SiteConfig::where('key', '=', 'seo_title')->update(['value' => $request->seo_title]);
        SiteConfig::where('key', '=', 'seo_description')->update(['value' => $request->seo_description]);
        SiteConfig::where('key', '=', 'payment_info')->update(['value' => $request->payment_info]);
        return back()->with(['flash_message_succ' => 'Cập nhật thông tin thành công!']);
    }

    public function slide() {
        $listSlides = SiteConfig::where('key', '=', 'slide')->first();
        $listSlides = json_decode($listSlides->value, false);
        return view('backends.config.slide', compact('listSlides'));
    }

    public function updateSlide(UpdateSiteConfigRequest $request) {
        Cache::forget('site_config');
        SiteConfig::where('key', '=', 'logo')->update(['value' => $request->logo]);
        SiteConfig::where('key', '=', 'email')->update(['value' => $request->email]);
        SiteConfig::where('key', '=', 'address')->update(['value' => $request->address]);
        SiteConfig::where('key', '=', 'phone')->update(['value' => $request->phone]);
        SiteConfig::where('key', '=', 'phone_2')->update(['value' => $request->phone_2]);
        SiteConfig::where('key', '=', 'facebook')->update(['value' => $request->facebook]);
        SiteConfig::where('key', '=', 'youtube')->update(['value' => $request->youtube]);
        SiteConfig::where('key', '=', 'instagram')->update(['value' => $request->instagram]);
        SiteConfig::where('key', '=', 'lat')->update(['value' => $request->lat]);
        SiteConfig::where('key', '=', 'lng')->update(['value' => $request->lng]);
        return back()->with(['flash_message_succ' => 'Cập nhật thông tin thành công!']);
    }
}