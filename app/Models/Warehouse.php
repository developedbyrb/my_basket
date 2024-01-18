<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warehouse extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'owner',
    ];

    /**
     * Get the comments for the blog post.
     */
    public function address(): HasMany
    {
        return $this->hasMany(ShopAddress::class);
    }

    public function defaultAddress()
    {
        $addressData = $this->address->where('is_default', 1)->first();
        if ($addressData) {
            $stateName = '';
            foreach (config('globalConstant.GEO_CONFIG_STATES') as $value) {
                if ($value['id'] == $addressData->state) {
                    $stateName = $value['name'];
                }
            }

            $countryName = '';
            foreach (config('globalConstant.GEO_CONFIG_COUNTRIES') as $value) {
                if ($value['id'] == $addressData->country) {
                    $countryName = $value['name'];
                }
            }

            return $addressData->house_no.', '.$addressData->area.', '.$addressData->city.', '.
                $stateName.', '.$countryName;
        }

        return '-';
    }
}
