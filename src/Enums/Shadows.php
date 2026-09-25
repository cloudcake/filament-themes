<?php

namespace Cloudcake\Themes\Enums;

enum Shadows
{
    case None;
    case Faint;
    case Whisper;
    case Soft;
    case Slight;
    case Default;
    case Moderate;
    case Strong;
    case Dramatic;
    case Excessive;

    public function tokens(): array
    {
        return match ($this) {
            self::None => [
                'shadow-2xs' => 'var(--shadow-none)',
                'shadow-xs' => 'var(--shadow-none)',
                'shadow-sm' => 'var(--shadow-none)',
                'shadow-md' => 'var(--shadow-none)',
                'shadow-lg' => 'var(--shadow-none)',
                'shadow-xl' => 'var(--shadow-none)',
                'shadow-2xl' => 'var(--shadow-none)',
                'shadow-3xl' => 'var(--shadow-none)',
                'shadow-4xl' => 'var(--shadow-none)',
            ],

            self::Faint => [
                'shadow-2xs' => '0 1px 0 var(--tw-shadow-color, rgb(0 0 0 / 1%))',
                'shadow-xs' => '0 1px 2px 0 var(--tw-shadow-color, rgb(0 0 0 / 1%))',
                'shadow-sm' => '0 1px 2px 0 var(--tw-shadow-color, rgb(0 0 0 / 3%)), 0 1px 1px -1px var(--tw-shadow-color, rgb(0 0 0 / 3%))',
                'shadow-md' => '0 2px 4px -1px var(--tw-shadow-color, rgb(0 0 0 / 3%)), 0 1px 2px -1px var(--tw-shadow-color, rgb(0 0 0 / 3%))',
                'shadow-lg' => '0 5px 8px -2px var(--tw-shadow-color, rgb(0 0 0 / 3%)), 0 2px 4px -2px var(--tw-shadow-color, rgb(0 0 0 / 3%))',
                'shadow-xl' => '0 10px 14px -4px var(--tw-shadow-color, rgb(0 0 0 / 3%)), 0 4px 6px -4px var(--tw-shadow-color, rgb(0 0 0 / 3%))',
                'shadow-2xl' => '0 15px 30px -10px var(--tw-shadow-color, rgb(0 0 0 / 8%))',
                'shadow-3xl' => '0 20px 36px -12px var(--tw-shadow-color, rgb(0 0 0 / 10%))',
                'shadow-4xl' => '0 28px 48px -15px var(--tw-shadow-color, rgb(0 0 0 / 12%))',
            ],

            self::Whisper => [
                'shadow-2xs' => '0 1px 0 var(--tw-shadow-color, rgb(0 0 0 / 2%))',
                'shadow-xs' => '0 1px 2px 0 var(--tw-shadow-color, rgb(0 0 0 / 2%))',
                'shadow-sm' => '0 1px 3px 0 var(--tw-shadow-color, rgb(0 0 0 / 4%)), 0 1px 2px -1px var(--tw-shadow-color, rgb(0 0 0 / 4%))',
                'shadow-md' => '0 3px 5px -1px var(--tw-shadow-color, rgb(0 0 0 / 4%)), 0 2px 3px -2px var(--tw-shadow-color, rgb(0 0 0 / 4%))',
                'shadow-lg' => '0 7px 11px -3px var(--tw-shadow-color, rgb(0 0 0 / 4%)), 0 3px 5px -4px var(--tw-shadow-color, rgb(0 0 0 / 4%))',
                'shadow-xl' => '0 14px 18px -5px var(--tw-shadow-color, rgb(0 0 0 / 4%)), 0 6px 8px -6px var(--tw-shadow-color, rgb(0 0 0 / 4%))',
                'shadow-2xl' => '0 20px 40px -12px var(--tw-shadow-color, rgb(0 0 0 / 10%))',
                'shadow-3xl' => '0 28px 48px -15px var(--tw-shadow-color, rgb(0 0 0 / 12%))',
                'shadow-4xl' => '0 36px 64px -20px var(--tw-shadow-color, rgb(0 0 0 / 14%))',
            ],

            self::Soft => [
                'shadow-2xs' => '0 1px 0 var(--tw-shadow-color, rgb(0 0 0 / 3%))',
                'shadow-xs' => '0 1px 2px 0 var(--tw-shadow-color, rgb(0 0 0 / 3%))',
                'shadow-sm' => '0 1px 3px 0 var(--tw-shadow-color, rgb(0 0 0 / 6%)), 0 1px 2px -1px var(--tw-shadow-color, rgb(0 0 0 / 6%))',
                'shadow-md' => '0 3px 5px -1px var(--tw-shadow-color, rgb(0 0 0 / 6%)), 0 2px 3px -2px var(--tw-shadow-color, rgb(0 0 0 / 6%))',
                'shadow-lg' => '0 8px 12px -3px var(--tw-shadow-color, rgb(0 0 0 / 6%)), 0 3px 6px -4px var(--tw-shadow-color, rgb(0 0 0 / 6%))',
                'shadow-xl' => '0 16px 20px -5px var(--tw-shadow-color, rgb(0 0 0 / 6%)), 0 6px 9px -6px var(--tw-shadow-color, rgb(0 0 0 / 6%))',
                'shadow-2xl' => '0 22px 44px -12px var(--tw-shadow-color, rgb(0 0 0 / 15%))',
                'shadow-3xl' => '0 30px 52px -15px var(--tw-shadow-color, rgb(0 0 0 / 17%))',
                'shadow-4xl' => '0 40px 68px -20px var(--tw-shadow-color, rgb(0 0 0 / 20%))',
            ],

            self::Slight => [
                'shadow-2xs' => '0 1px 0 var(--tw-shadow-color, rgb(0 0 0 / 2%))',
                'shadow-xs' => '0 1px 2px 0 var(--tw-shadow-color, rgb(0 0 0 / 2%))',
                'shadow-sm' => '0 1px 3px 0 var(--tw-shadow-color, rgb(0 0 0 / 5%)), 0 1px 2px -1px var(--tw-shadow-color, rgb(0 0 0 / 5%))',
                'shadow-md' => '0 3px 5px -1px var(--tw-shadow-color, rgb(0 0 0 / 5%)), 0 2px 3px -2px var(--tw-shadow-color, rgb(0 0 0 / 5%))',
                'shadow-lg' => '0 7px 11px -3px var(--tw-shadow-color, rgb(0 0 0 / 5%)), 0 3px 5px -4px var(--tw-shadow-color, rgb(0 0 0 / 5%))',
                'shadow-xl' => '0 14px 18px -5px var(--tw-shadow-color, rgb(0 0 0 / 5%)), 0 6px 8px -6px var(--tw-shadow-color, rgb(0 0 0 / 5%))',
                'shadow-2xl' => '0 20px 40px -12px var(--tw-shadow-color, rgb(0 0 0 / 12%))',
                'shadow-3xl' => '0 28px 48px -15px var(--tw-shadow-color, rgb(0 0 0 / 15%))',
                'shadow-4xl' => '0 36px 64px -20px var(--tw-shadow-color, rgb(0 0 0 / 18%))',
            ],

            self::Default => [
                'shadow-2xs' => '0 1px 0 var(--tw-shadow-color, rgb(0 0 0 / 5%))',
                'shadow-xs' => '0 1px 2px 0 var(--tw-shadow-color, rgb(0 0 0 / 5%))',
                'shadow-sm' => '0 1px 3px 0 var(--tw-shadow-color, rgb(0 0 0 / 10%)), 0 1px 2px -1px var(--tw-shadow-color, rgb(0 0 0 / 10%))',
                'shadow-md' => '0 4px 6px -1px var(--tw-shadow-color, rgb(0 0 0 / 10%)), 0 2px 4px -2px var(--tw-shadow-color, rgb(0 0 0 / 10%))',
                'shadow-lg' => '0 10px 15px -3px var(--tw-shadow-color, rgb(0 0 0 / 10%)), 0 4px 6px -4px var(--tw-shadow-color, rgb(0 0 0 / 10%))',
                'shadow-xl' => '0 20px 25px -5px var(--tw-shadow-color, rgb(0 0 0 / 10%)), 0 8px 10px -6px var(--tw-shadow-color, rgb(0 0 0 / 10%))',
                'shadow-2xl' => '0 25px 50px -12px var(--tw-shadow-color, rgb(0 0 0 / 25%))',
                'shadow-3xl' => '0 35px 60px -15px var(--tw-shadow-color, rgb(0 0 0 / 30%))',
                'shadow-4xl' => '0 45px 80px -20px var(--tw-shadow-color, rgb(0 0 0 / 35%))',
            ],

            self::Moderate => [
                'shadow-2xs' => '0 1px 1px var(--tw-shadow-color, rgb(0 0 0 / 7%))',
                'shadow-xs' => '0 1px 3px 0 var(--tw-shadow-color, rgb(0 0 0 / 8%))',
                'shadow-sm' => '0 2px 5px 0 var(--tw-shadow-color, rgb(0 0 0 / 12%)), 0 2px 3px -1px var(--tw-shadow-color, rgb(0 0 0 / 12%))',
                'shadow-md' => '0 5px 9px -1px var(--tw-shadow-color, rgb(0 0 0 / 13%)), 0 3px 6px -2px var(--tw-shadow-color, rgb(0 0 0 / 13%))',
                'shadow-lg' => '0 12px 18px -3px var(--tw-shadow-color, rgb(0 0 0 / 14%)), 0 5px 9px -4px var(--tw-shadow-color, rgb(0 0 0 / 14%))',
                'shadow-xl' => '0 24px 30px -5px var(--tw-shadow-color, rgb(0 0 0 / 15%)), 0 10px 14px -6px var(--tw-shadow-color, rgb(0 0 0 / 15%))',
                'shadow-2xl' => '0 30px 60px -12px var(--tw-shadow-color, rgb(0 0 0 / 30%))',
                'shadow-3xl' => '0 42px 72px -15px var(--tw-shadow-color, rgb(0 0 0 / 35%))',
                'shadow-4xl' => '0 54px 96px -20px var(--tw-shadow-color, rgb(0 0 0 / 40%))',
            ],

            self::Strong => [
                'shadow-2xs' => '0 1px 2px var(--tw-shadow-color, rgb(0 0 0 / 10%))',
                'shadow-xs' => '0 2px 4px 0 var(--tw-shadow-color, rgb(0 0 0 / 11%))',
                'shadow-sm' => '0 3px 7px 0 var(--tw-shadow-color, rgb(0 0 0 / 16%)), 0 2px 4px -1px var(--tw-shadow-color, rgb(0 0 0 / 16%))',
                'shadow-md' => '0 6px 12px -1px var(--tw-shadow-color, rgb(0 0 0 / 17%)), 0 4px 7px -2px var(--tw-shadow-color, rgb(0 0 0 / 17%))',
                'shadow-lg' => '0 15px 23px -3px var(--tw-shadow-color, rgb(0 0 0 / 18%)), 0 6px 11px -4px var(--tw-shadow-color, rgb(0 0 0 / 18%))',
                'shadow-xl' => '0 28px 35px -5px var(--tw-shadow-color, rgb(0 0 0 / 20%)), 0 12px 18px -6px var(--tw-shadow-color, rgb(0 0 0 / 20%))',
                'shadow-2xl' => '0 35px 70px -12px var(--tw-shadow-color, rgb(0 0 0 / 38%))',
                'shadow-3xl' => '0 50px 85px -15px var(--tw-shadow-color, rgb(0 0 0 / 45%))',
                'shadow-4xl' => '0 65px 110px -20px var(--tw-shadow-color, rgb(0 0 0 / 50%))',
            ],

            self::Dramatic => [
                'shadow-2xs' => '0 2px 3px var(--tw-shadow-color, rgb(0 0 0 / 13%))',
                'shadow-xs' => '0 3px 6px 0 var(--tw-shadow-color, rgb(0 0 0 / 14%))',
                'shadow-sm' => '0 4px 10px 0 var(--tw-shadow-color, rgb(0 0 0 / 20%)), 0 3px 6px -1px var(--tw-shadow-color, rgb(0 0 0 / 20%))',
                'shadow-md' => '0 8px 16px -1px var(--tw-shadow-color, rgb(0 0 0 / 22%)), 0 5px 10px -2px var(--tw-shadow-color, rgb(0 0 0 / 22%))',
                'shadow-lg' => '0 18px 30px -3px var(--tw-shadow-color, rgb(0 0 0 / 24%)), 0 8px 14px -4px var(--tw-shadow-color, rgb(0 0 0 / 24%))',
                'shadow-xl' => '0 35px 45px -5px var(--tw-shadow-color, rgb(0 0 0 / 27%)), 0 15px 23px -6px var(--tw-shadow-color, rgb(0 0 0 / 27%))',
                'shadow-2xl' => '0 45px 90px -12px var(--tw-shadow-color, rgb(0 0 0 / 48%))',
                'shadow-3xl' => '0 65px 110px -15px var(--tw-shadow-color, rgb(0 0 0 / 55%))',
                'shadow-4xl' => '0 85px 140px -20px var(--tw-shadow-color, rgb(0 0 0 / 62%))',
            ],

            self::Excessive => [
                'shadow-2xs' => '0 2px 4px var(--tw-shadow-color, rgb(0 0 0 / 18%))',
                'shadow-xs' => '0 4px 8px 0 var(--tw-shadow-color, rgb(0 0 0 / 20%))',
                'shadow-sm' => '0 5px 12px 0 var(--tw-shadow-color, rgb(0 0 0 / 28%)), 0 4px 8px -1px var(--tw-shadow-color, rgb(0 0 0 / 28%))',
                'shadow-md' => '0 10px 20px -1px var(--tw-shadow-color, rgb(0 0 0 / 30%)), 0 6px 12px -2px var(--tw-shadow-color, rgb(0 0 0 / 30%))',
                'shadow-lg' => '0 22px 38px -3px var(--tw-shadow-color, rgb(0 0 0 / 33%)), 0 10px 18px -4px var(--tw-shadow-color, rgb(0 0 0 / 33%))',
                'shadow-xl' => '0 42px 55px -5px var(--tw-shadow-color, rgb(0 0 0 / 36%)), 0 18px 28px -6px var(--tw-shadow-color, rgb(0 0 0 / 36%))',
                'shadow-2xl' => '0 55px 110px -12px var(--tw-shadow-color, rgb(0 0 0 / 60%))',
                'shadow-3xl' => '0 80px 140px -15px var(--tw-shadow-color, rgb(0 0 0 / 68%))',
                'shadow-4xl' => '0 105px 180px -20px var(--tw-shadow-color, rgb(0 0 0 / 75%))',
            ],
        };
    }
}