<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyEntries extends Model
{
    //
    protected $table = 'cash_entries';

    public function Account()
    {
        return $this->belongsTo(AccountsTree::class, 'accounts_tree_id');
    }

    public function Operation()
    {
        return $this->belongsTo(EntriesOperations::class, 'entries_operations_id');
    }
}
