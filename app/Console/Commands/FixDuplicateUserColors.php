<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class FixDuplicateUserColors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:fix-colors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix duplicate chat colors for users - ensures each user has a unique color';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for duplicate user colors...');
        
        // Get all users with their colors
        $users = User::all();
        $usedColors = [];
        $fixedCount = 0;
        
        foreach ($users as $user) {
            // If color is null or already used, assign a new unique color
            if (empty($user->chat_color) || in_array($user->chat_color, $usedColors)) {
                $oldColor = $user->chat_color ?? 'null';
                
                // Get a new unique color
                $newColor = $this->getUniqueColorExcluding($usedColors);
                
                $user->chat_color = $newColor;
                $user->save();
                
                $this->line("  Fixed: {$user->name} (ID: {$user->id}) - {$oldColor} → {$newColor}");
                $fixedCount++;
            }
            
            // Track this color as used
            $usedColors[] = $user->chat_color;
        }
        
        if ($fixedCount > 0) {
            $this->info("✅ Fixed {$fixedCount} user(s) with duplicate/missing colors.");
        } else {
            $this->info('✅ All users already have unique colors!');
        }
        
        return Command::SUCCESS;
    }
    
    /**
     * Get a unique color that is not in the excluded list
     */
    private function getUniqueColorExcluding(array $excludedColors): string
    {
        // Find available colors from predefined list
        $availableColors = array_diff(User::$chatColors, $excludedColors);
        
        if (!empty($availableColors)) {
            return $availableColors[array_rand($availableColors)];
        }
        
        // Generate a random unique color
        $maxAttempts = 100;
        $attempts = 0;
        
        do {
            $hue = rand(0, 360);
            $saturation = rand(60, 90);
            $lightness = rand(40, 60);
            
            $color = $this->hslToHex($hue, $saturation, $lightness);
            $attempts++;
        } while (in_array($color, $excludedColors) && $attempts < $maxAttempts);
        
        return $color;
    }
    
    /**
     * Convert HSL to Hex color
     */
    private function hslToHex(int $h, int $s, int $l): string
    {
        $s /= 100;
        $l /= 100;
        
        $c = (1 - abs(2 * $l - 1)) * $s;
        $x = $c * (1 - abs(fmod($h / 60, 2) - 1));
        $m = $l - $c / 2;
        
        if ($h < 60) {
            $r = $c; $g = $x; $b = 0;
        } elseif ($h < 120) {
            $r = $x; $g = $c; $b = 0;
        } elseif ($h < 180) {
            $r = 0; $g = $c; $b = $x;
        } elseif ($h < 240) {
            $r = 0; $g = $x; $b = $c;
        } elseif ($h < 300) {
            $r = $x; $g = 0; $b = $c;
        } else {
            $r = $c; $g = 0; $b = $x;
        }
        
        $r = round(($r + $m) * 255);
        $g = round(($g + $m) * 255);
        $b = round(($b + $m) * 255);
        
        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }
}
