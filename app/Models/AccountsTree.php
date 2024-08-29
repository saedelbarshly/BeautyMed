<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountsTree extends Model
{
    //
    public function Entries()
    {
        return $this->hasMany(DailyEntries::class);
    }

    public function getTheBalanceTotal($dates = null)
    {
        $accountsArr = [];
        $thisAccountSubsIds = [];
        $thisAccountSubsIds[] = $this->id;
        $subAccounts1 = AccountsTree::where('MainAccID',$this->id)->get();
        if (count($subAccounts1) > 0) {
            foreach ($subAccounts1 as $subAccounts1V) {
                if (!in_array($subAccounts1V['id'],$thisAccountSubsIds)) {
                    $thisAccountSubsIds[] = $subAccounts1V['id'];
                }
                $subAccounts2 = AccountsTree::where('MainAccID',$subAccounts1V['id'])->get();
                if (count($subAccounts2) > 0) {
                    foreach ($subAccounts2 as $subAccounts2V) {
                        if (!in_array($subAccounts2V['id'],$thisAccountSubsIds)) {
                            $thisAccountSubsIds[] = $subAccounts2V['id'];
                        }
                        $subAccounts3 = AccountsTree::where('MainAccID',$subAccounts2V['id'])->get();
                        if (count($subAccounts3) > 0) {
                            foreach ($subAccounts3 as $subAccounts3V) {
                                if (!in_array($subAccounts3V['id'],$thisAccountSubsIds)) {
                                    $thisAccountSubsIds[] = $subAccounts3V['id'];
                                }
                                $subAccounts4 = AccountsTree::where('MainAccID',$subAccounts3V['id'])->get();
                                if (count($subAccounts4) > 0) {
                                    foreach ($subAccounts4 as $subAccounts4V) {
                                        if (!in_array($subAccounts4V['id'],$thisAccountSubsIds)) {
                                            $thisAccountSubsIds[] = $subAccounts4V['id'];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if ($dates != null) {
            $thisCreditTotal = DailyEntries::whereIn('PaymentDate',$dates)->whereIn('accounts_tree_id',[$thisAccountSubsIds])->sum('Credit');
            $thisDebitTotal = DailyEntries::whereIn('PaymentDate',$dates)->whereIn('accounts_tree_id',[$thisAccountSubsIds])->sum('Debit');
        } else {
            $thisCreditTotal = DailyEntries::whereIn('accounts_tree_id',[$thisAccountSubsIds])->sum('Credit');
            $thisDebitTotal = DailyEntries::whereIn('accounts_tree_id',[$thisAccountSubsIds])->sum('Debit');
        }
        return $thisCreditTotal - $thisDebitTotal;
    }
}
