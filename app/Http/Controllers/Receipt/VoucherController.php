<?php
namespace App\Http\Controllers\Receipt;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class VoucherController extends Controller
{
    public function index(){ return view('section',['name'=>'vouchers']); }
    public function create(){ return view('section',['name'=>'voucher-create']); }
    public function store(Request $r){ return back()->with('success','Voucher saved'); }
    public function show($id){ return view('section',['name'=>'voucher-show']); }
    public function edit($id){ return view('section',['name'=>'voucher-edit']); }
    public function update(Request $r,$id){ return back()->with('success','Voucher updated'); }
    public function destroy($id){ return back()->with('success','Voucher deleted'); }
}
