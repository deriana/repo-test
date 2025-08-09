<?php

namespace App\Models;

use App\Enums\LetterType;
use App\Enums\Config as ConfigEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Letter extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'reference_number',
        'agenda_number',
        'from',
        'to',
        'letter_date',
        'received_date',
        'description',
        'note',
        'type',
        'classification_code',
        'user_id',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'letter_date' => 'date',
        'received_date' => 'date',
    ];

    protected $appends = [
        'formatted_letter_date',
        'formatted_received_date',
        'formatted_created_at',
        'formatted_updated_at',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function classification(): BelongsTo
    {
        return $this->belongsTo(Classification::class, 'classification_code', 'code');
    }

    /**
     * @return HasMany
     */
    public function dispositions(): HasMany
    {
        return $this->hasMany(Disposition::class, 'letter_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class, 'letter_id', 'id');
    }

    public static function getIncomingTodayCount()
    {
        return self::where('type', 'incoming')
            ->whereDate('created_at', now()->toDateString())
            ->count();
    }

    public static function getOutgoingTodayCount()
    {
        return self::where('type', 'outgoing')
            ->whereDate('created_at', now()->toDateString())
            ->count();
    }

    public static function getIncomingYesterdayCount()
    {
        return self::where('type', 'incoming')
            ->whereDate('created_at', now()->subDay()->toDateString())
            ->count();
    }

    public static function getOutgoingYesterdayCount()
    {
        return self::where('type', 'outgoing')
            ->whereDate('created_at', now()->subDay()->toDateString())
            ->count();
    }

    public static function countIncomingByDate(string $date): int
    {
        return self::where('type', 'incoming')
            ->whereDate('created_at', $date)
            ->count();
    }

    public static function countOutgoingByDate(string $date): int
    {
        return self::where('type', 'outgoing')
            ->whereDate('created_at', $date)
            ->count();
    }
}
