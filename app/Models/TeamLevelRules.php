<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class TeamLevelRules extends Model
{
    protected $table = 'team_level_rules'; 
    public $timestamps = true;

    protected $fillable = ['level','level_name','personal_holding','team_requirement_type','team_requirement_value','team_requirement_level','team_requirement_count','valid_referrals','profit_ratio_min','profit_ratio_max'];

    public static function asMatrix(bool $useCache = true): array
    {
        $key = 'team_level_rules.matrix.v1';

        if ($useCache) {
            return Cache::remember($key, 300, fn () => self::buildMatrix());
        }

        return self::buildMatrix();
    }

    private static function buildMatrix(): array
    {
        /** @var Collection<int,object> $rows */
        $rows = DB::table('team_level_rules')->orderBy('level')->get();

        $matrix = [];

        foreach ($rows as $r) {
            // Build team_requirement shape
            if (($r->team_requirement_type ?? '') === 'volume') {
                $teamRequirement = [
                    'type'  => 'volume',
                    'value' => (int) ($r->team_requirement_value ?? 0),
                ];
            } else {
                // hold_level
                $teamRequirement = [
                    'type'  => 'hold_level',
                    'level' => (int) ($r->team_requirement_level ?? 0),
                    'count' => (int) ($r->team_requirement_count ?? 0),
                    // keep your extra 'value' field if you use it at L10+:
                    'value' => (int) ($r->team_requirement_value ?? 0),
                ];
            }

            $matrix[(int)$r->level] = [
                'level'            => (string) $r->level,
                'personal_holding' => (int) $r->personal_holding,
                'team_requirement' => $teamRequirement,
                'valid_referrals'  => (int) $r->valid_referrals,
                'profit_ratio'     => [
                    (int) $r->profit_ratio_min,
                    (int) $r->profit_ratio_max,
                ],
            ];
        }

        return $matrix;
    }
}
