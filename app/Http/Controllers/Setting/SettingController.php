<?php
namespace App\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class SettingController extends Controller
{
    public function index(){ return view('section',['name'=>'settings']); }
    public function update(Request $r){ return back()->with('success','Settings updated'); }
}
