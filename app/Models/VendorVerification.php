<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',

        // Business Information
        'business_name',
        'business_type',
        'business_registration_number',
        'tax_id',

        // Owner Information
        'owner_name',
        'owner_phone',
        'owner_email',

        // Documents
        'business_license',
        'tax_document',
        'identity_document',
        'address_proof',

        // Verification
        'status',
        'submitted_at',
        'reviewed_at',
        'verified_at',

        // Review
        'reviewed_by',
        'rejection_reason',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'reviewed_at' => 'datetime',
            'verified_at' => 'datetime',
        ];
    }

    /**
     * Vendor relationship
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Admin who reviewed the verification
     */
    public function reviewer()
    {
        return $this->belongsTo(Admin::class, 'reviewed_by');
    }

    /**
     * Status helpers
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function needsRevision(): bool
    {
        return $this->status === 'revision_required';
    }
}
