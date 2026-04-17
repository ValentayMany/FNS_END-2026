<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestWorkflowLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'request_id',
        'user_id',
        'actor_role_name',
        'action',
        'timestamp',
        'comments',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];

    public function advanceRequest()
    {
        return $this->belongsTo(AdvanceRequest::class, 'request_id');
    }

    public function actor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** Lao UI label for roles.roles.role_name slugs (matches DB). */
    public static function roleSlugLabels(): array
    {
        return [
            'admin' => 'ຜູ້ດູແລລະບົບ',
            'requester' => 'ຜູ້ຂໍ',
            'accountant' => 'ນັກບັນຊີ',
            'head_of_finance' => 'ຫົວໜ້າການເງິນ',
            'deputy_head_of_faculty' => 'ຮອງຫົວໜ້າຄະນະ',
            'head_of_faculty' => 'ຫົວໜ້າຄະນະ',
            'head_of_department' => 'ຫົວໜ້າພາກວິຊາ',
            'cashier' => 'ເກັບເງິນ',
            'revenue_officer' => 'ເຈົ້າໜ້າທີ່ລາຍຮັບ',
            'treasurer' => 'ຄັງເງິນ',
            'treasury_reconciliation_officer' => 'ສະສາງຄັງເງິນ',
        ];
    }

    /** Role text for timeline: snapshot first, then actor's current role; shown in Lao when known. */
    public function actorRoleDisplay(): string
    {
        $slug = $this->actor_role_name ?? $this->actor?->role?->role_name;
        if ($slug === null || $slug === '') {
            return '—';
        }

        return self::roleSlugLabels()[$slug] ?? $slug;
    }
}
