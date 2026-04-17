<?php

namespace App\Models;

use App\Support\LaoText;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class AdvanceRequest extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'requester_id',
        'department_id',
        'request_date',
        'description',
        'requested_amount',
        'status',
        'payment_transaction_id',
    ];

    protected $casts = [
        'request_date' => 'date',
    ];

    /** Fix ລຽ້ງ-style mark order for display (DB may store wrong keyboard order). */
    protected function description(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => LaoText::normalize($value),
        );
    }

    // ---- Status Labels ----
    public static function statusLabels(): array
    {
        return [
            'draft' => 'ຮ່າງ',
            'pending_accountant_review' => 'ລໍຖ້ານາຍບັນຊີ',
            'pending_finance_head_review' => 'ລໍຖ້າຫົວໜ້າການເງິນ',
            'pending_deputy_head_approval' => 'ລໍຖ້າຮອງຫົວໜ້າ',
            'pending_faculty_head_approval' => 'ລໍຖ້າຫົວໜ້າຄະນະ',
            'approved' => 'ອະນຸມັດແລ້ວ',
            'paid' => 'ຈ່າຍເງິນແລ້ວ',
            'pending_clearing' => 'ລໍຖ້າສະສາງ',
            'cleared' => 'ສະສາງແລ້ວ',
            'rejected' => 'ປະຕິເສດ',
        ];
    }

    // ---- Relationships ----
    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function paymentTransaction()
    {
        return $this->belongsTo(Transaction::class, 'payment_transaction_id');
    }

    public function workflowLogs()
    {
        return $this->hasMany(RequestWorkflowLog::class, 'request_id')
            ->orderBy('timestamp');
    }

    public function clearingItems()
    {
        return $this->hasMany(AdvanceClearingItem::class, 'advance_request_id');
    }

    public function clearingAttachments()
    {
        return $this->hasMany(AdvanceClearingAttachment::class, 'advance_request_id');
    }

    // ---- Helpers ----
    public function canBeActedBy(User $user): bool
    {
        return match ($this->status) {
            'pending_accountant_review' => $user->isAccountant(),
            'pending_finance_head_review' => $user->isHeadOfFinance(),
            'pending_deputy_head_approval' => $user->isDeputyHead(),
            'pending_faculty_head_approval' => $user->isFacultyHead(),
            default => false,
        };
    }
}
