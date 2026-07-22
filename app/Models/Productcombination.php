<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class Productcombination extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function formattedName(?string $name): HtmlString
    {
        $name = trim((string) $name);
        $ohmSymbols = [
            "\u{03A9}",
            "\u{2126}",
            "\u{00CE}\u{00A9}",
            "\u{00E2}\u{201E}\u{00A6}",
        ];

        foreach ($ohmSymbols as $ohmSymbol) {
            if (str_contains($name, $ohmSymbol) && preg_match('/^\s*([0-9]+(?:\.[0-9]+)?)/', $name, $matches)) {
                return new HtmlString(e($matches[1]).' &ohm;');
            }
        }

        return new HtmlString(e($name));
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productkeyfeatures()
    {
        return $this->hasMany(Productkeyfeature::class);
    }

    public function productmountinginfos()
    {
        return $this->hasMany(Productmountinginfo::class);
    }

    public function productspecifications()
    {
        return $this->hasMany(Productspecification::class);
    }

    public function producttsparameters()
    {
        return $this->hasMany(Producttsparameter::class);
    }

    public function productreconkits()
    {
        return $this->hasMany(Productreconkit::class);
    }
}
