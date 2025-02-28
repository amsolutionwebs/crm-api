<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suparadminuploadedleads extends Model
{
    use HasFactory;

    protected $fillable = [
        'suparadmin_id',
        'name',
        'phone',
        'email',
        'email_host',
        'website',
        'category',
        'address',
        'city',
        'region',
        'zip',
        'country',
        'google_rank',
        'facebook',
        'instagram',
        'twitter',
        'linkedin',
        'googlestars',
        'googlereviewscount',
        'yelpstars',
        'yelpreviewscount',
        'facebookstars',
        'facebookreviewscount',
        'facebookpixel',
        'googlepixel',
        'criteopixel',
        'seo_schema',
        'googleanalytics',
        'linkedinanalytics',
        'uses_wordpress',
        'mobilefriendly',
        'uses_shopify',
        'domain_registration',
        'domain_expiration',
        'domain_registrar',
        'domain_nameserver',
        'instagram_name',
        'instagram_is_verified',
        'instagram_is_business_account',
        'instagram_media_count',
        'instagram_highlight_reel_count',
        'instagram_followers',
        'instagram_following',
        'instagram_category',
        'instagram_average_likes',
        'instagram_average_comments',
        'ads_yelp',
        'ads_facebook',
        'ads_instagram',
        'ads_messenger',
        'ads_adwords',
        'g_maps_claimed',
        'g_maps',
        'search_keyword',
        'search_city',
    ];
}
