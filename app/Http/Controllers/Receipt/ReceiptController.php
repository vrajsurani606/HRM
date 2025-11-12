<?php
namespace App\Http\Controllers\Receipt;
use App\Http\Controllers\Controller;
use App\Models\Receipt;
use Illuminate\Http\Request;
class ReceiptController extends Controller
{
    public function index(){ 
        $receipts = Receipt::latest()->get();
        return view('receipts.index', compact('receipts')); 
    }
    
    public function create(){ 
        return view('receipts.create'); 
    }
    
    public function store(Request $request){ 
        $validated = $request->validate([
            'unique_code' => 'required|string',
            'rec_date' => 'required|date',
            'company_name' => 'required|string',
            'total_amount' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'remain_amount' => 'required|numeric',
            'received_amount' => 'required|numeric|min:0',
            'payment_type' => 'required|in:cash,cheque,bank_transfer,online',
            'narration' => 'required|string',
            'trans_code' => 'required|string',
        ]);
        
        Receipt::create($validated);
        return redirect()->route('receipts.index')->with('success','Receipt created successfully'); 
    }
    
    public function show($id){ 
        $receipt = Receipt::findOrFail($id);
        return view('receipts.show', compact('receipt')); 
    }
    
    public function edit($id){ 
        $receipt = Receipt::findOrFail($id);
        return view('receipts.edit', compact('receipt')); 
    }
    
    public function update(Request $request, $id){ 
        $receipt = Receipt::findOrFail($id);
        $validated = $request->validate([
            'unique_code' => 'required|string',
            'rec_date' => 'required|date',
            'company_name' => 'required|string',
            'total_amount' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'remain_amount' => 'required|numeric',
            'received_amount' => 'required|numeric|min:0',
            'payment_type' => 'required|in:cash,cheque,bank_transfer,online',
            'narration' => 'required|string',
            'trans_code' => 'required|string',
        ]);
        
        $receipt->update($validated);
        return redirect()->route('receipts.index')->with('success','Receipt updated successfully'); 
    }
    
    public function destroy($id){ 
        $receipt = Receipt::findOrFail($id);
        $receipt->delete();
        return back()->with('success','Receipt deleted successfully'); 
    }
}
