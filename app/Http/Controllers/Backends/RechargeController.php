<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use App\Payment;
use App\BankAccount;
use App\Http\Controllers\Backends\Requests\StoreBankAccountRequest;

class RechargeController extends Controller
{
    public function bankTransfer()
    {
        $bank_transfer = Payment::find(5);
        return view('backends.recharge.bank-transfer', ['bank_transfer'=>$bank_transfer]);
    }

    public function getBankTransferAccountAjax()
    {
        $bank_accounts = BankAccount::orderBy('id', 'DESC')->get();
        return datatables()->collection($bank_accounts)
            ->addColumn('action', function ($bank_account) {
                return $bank_account->id;
            })
            ->removeColumn('id')->make(true);

    }

    public function addBankTransferAccountAjax(StoreBankAccountRequest $request)
    {
        $bank_account  = new BankAccount;

        $bank_account->name = $request->account_name;
        $bank_account->account_number = $request->account_number;
        $bank_account->bank_name = $request->bank_name;
        $bank_account->status = 0;
        
        $bank_account->save();
        return \Response::json(array('status' => '200', 'message' => 'Thêm tài khoản thành công'));
    }

    public function editBankTransferAccount(StoreBankAccountRequest $request)
    {
        $bank_account  = BankAccount::find($request->id);

        $bank_account->name = $request->account_name;
        $bank_account->account_number = $request->account_number;
        $bank_account->bank_name = $request->bank_name;
        
        $bank_account->save();
        return \Response::json(array('status' => '200', 'message' => 'Sửa tài khoản thành công'));
    }

    public function deleteBankTransferAccount(Request $request)
    {
        $bank_account  = BankAccount::find($request->id)->delete();
        return \Response::json(array('status' => '200', 'message' => 'Xóa tài khoản thành công'));
    }

    public function saveBankTransferSetting(Request $request)
    {
        $bank_transfer = Payment::find(5);

        if ( $bank_transfer ){
            $bank_transfer->title = $request->title_desc;
            $bank_transfer->description = $request->description;
            $bank_transfer->instruction = $request->instruction;
            $bank_transfer->status = $request->turn_on_off;
    
            $bank_transfer->save();
    
            $accounts = BankAccount::get();
            if ( $accounts->count() > 0 ){
                foreach( $accounts as $account ){
                    $account->status = 0;
                    $account->save();
                }
            }
            $account = BankAccount::find($request->account_id);
            if ( $account ){
                $account->status = 1;
                $account->save();
            }
    
            return \Response::json(array('status' => '200', 'message' => 'Sửa thông tin chuyển khoản ngân hàng thành công'));
        }
    }
}
