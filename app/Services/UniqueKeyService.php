<?php

namespace App\Services;

use App\Models\UniqueKey;
use Illuminate\Support\Str;

class UniqueKeyService
{
    /**
     * Generate or replace the user's API key.
     *
     * Returns the plain key because it cannot be recovered later.
     */
    public function generate(int $userId, string $name = 'Unique Key'): string
    {
        $plainKey = 'AIA_' . Str::random(64);

        UniqueKey::updateOrCreate(
            ['user_id' => $userId],
            [
                'name' => $name,
                'key_hash' => hash('sha256', $plainKey),
                'revoked_at' => null,
                'last_used_at' => null,
            ]
        );

        return $plainKey;
    }

    /**
     * Regenerate the user's API key.
     */
    public function regenerate(int $userId): string
    {
        return $this->generate($userId);
    }

    public function ensure(int $userId): ?string
    {
        $key = UniqueKey::where('user_id', $userId)
            ->whereNull('revoked_at')
            ->first();

        if ($key) {
            return null;
        }

        return $this->generate($userId);
    }

    /**
     * Validate an API key.
     */
    public function validate(string $plainKey): ?UniqueKey
    {
        return UniqueKey::where('key_hash', hash('sha256', $plainKey))
            ->whereNull('revoked_at')
            ->first();
    }

    /**
     * Mark the key as used.
     */
    public function markAsUsed(UniqueKey $key): void
    {
        $key->update([
            'last_used_at' => now(),
        ]);
    }

    /**
     * Revoke a key.
     */
    public function revoke(int $userId): void
    {
        UniqueKey::where('user_id', $userId)->update([
            'revoked_at' => now(),
        ]);
    }
}