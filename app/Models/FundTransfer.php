<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FundTransfer extends Model
{
    use HasFactory,SoftDeletes;

    // Relation With Transaction
    public function inTransactionId() {
        return $this->belongsTo(Transaction::class, 'in_transaction_id')->withTrashed();
    }

    public function outTransactionId() {
        return $this->belongsTo(Transaction::class, 'out_transaction_id')->withTrashed();
    }

    // Relation With User Model
    public function createdByUser() {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relation With User Model
    public function updatedByUser() {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
