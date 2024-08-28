<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Suparadminuploadedleads;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ManagerImports implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    protected $manager_id;

    public function __construct($manager_id)
    {
        $this->manager_id = $manager_id;
    }



    public function collection(Collection $rows)
    {
         foreach ($rows as $row) 
        {
            $lead = Suparadminuploadedleads::where('name',$row['name'])->where('phone',$row['phone'])->where('email',$row['email'])->first();
            if($lead)
            {
                $lead->update([
           'manager_id' => $this->manager_id,
            
            'email_host' => $row['email_host'] ?? null,
            'website' => $row['website'] ?? null,
            'category' => $row['category'] ?? null,
            'address' => $row['address'] ?? null,
            'city' => $row['city'] ?? null,
            'region' => $row['region'] ?? null,
            'zip' => $row['zip'] ?? null,
            'country' => $row['country'] ?? null,
            'google_rank' => $row['google_rank'] ?? null,
            'facebook' => $row['facebook'] ?? null,
            'instagram' => $row['instagram'] ?? null,
            'twitter' => $row['twitter'] ?? null,
            'linkedin' => $row['linkedin'] ?? null,
            'googlestars' => $row['googlestars'] ?? null,
            'googlereviewscount' => $row['googlereviewscount'] ?? null,
            'yelpstars' => $row['yelpstars'] ?? null,
            'yelpreviewscount' => $row['yelpreviewscount'] ?? null,
            'facebookstars' => $row['facebookstars'] ?? null,
            'facebookreviewscount' => $row['facebookreviewscount'] ?? null,
            'facebookpixel' => $row['facebookpixel'] ?? null,
            'googlepixel' => $row['googlepixel'] ?? null,
            'criteopixel' => $row['criteopixel'] ?? null,
            'seo_schema' => $row['seo_schema'] ?? null,
            'googleanalytics' => $row['googleanalytics'] ?? null,
            'linkedinanalytics' => $row['linkedinanalytics'] ?? null,
            'uses_wordpress' => $row['uses_wordpress'] ?? null,
            'mobilefriendly' => $row['mobilefriendly'] ?? null,
            'uses_shopify' => $row['uses_shopify'] ?? null,
            'domain_registration' => $row['domain_registration'] ?? null,
            'domain_expiration' => $row['domain_expiration'] ?? null,
            'domain_registrar' => $row['domain_registrar'] ?? null,
            'domain_nameserver' => $row['domain_nameserver'] ?? null,
            'instagram_name' => $row['instagram_name'] ?? null,
            'instagram_is_verified' => $row['instagram_is_verified'] ?? null,
            'instagram_is_business_account' => $row['instagram_is_business_account'] ?? null,
            'instagram_media_count' => $row['instagram_media_count'] ?? null,
            'instagram_highlight_reel_count' => $row['instagram_highlight_reel_count'] ?? null,
            'instagram_followers' => $row['instagram_followers'] ?? null,
            'instagram_following' => $row['instagram_following'] ?? null,
            'instagram_category' => $row['instagram_category'] ?? null,
            'instagram_average_likes' => $row['instagram_average_likes'] ?? null,
            'instagram_average_comments' => $row['instagram_average_comments'] ?? null,
            'ads_yelp' => $row['ads_yelp'] ?? null,
            'ads_facebook' => $row['ads_facebook'] ?? null,
            'ads_instagram' => $row['ads_instagram'] ?? null,
            'ads_messenger' => $row['ads_messenger'] ?? null,
            'ads_adwords' => $row['ads_adwords'] ?? null,
            'g_maps_claimed' => $row['g_maps_claimed'] ?? null,
            'g_maps' => $row['g_maps'] ?? null,
            'search_keyword' => $row['search_keyword'] ?? null,
            'search_city' => $row['search_city'] ?? null,
            ]);

            }else{
               Suparadminuploadedleads::create([
             'manager_id' => $this->manager_id,
            'name' => $row['name'] ?? null, // Using null coalescing to handle missing keys
            'phone' => $row['phone'] ?? null,
            'email' => $row['email'] ?? null,
            'email_host' => $row['email_host'] ?? null,
            'website' => $row['website'] ?? null,
            'category' => $row['category'] ?? null,
            'address' => $row['address'] ?? null,
            'city' => $row['city'] ?? null,
            'region' => $row['region'] ?? null,
            'zip' => $row['zip'] ?? null,
            'country' => $row['country'] ?? null,
            'google_rank' => $row['google_rank'] ?? null,
            'facebook' => $row['facebook'] ?? null,
            'instagram' => $row['instagram'] ?? null,
            'twitter' => $row['twitter'] ?? null,
            'linkedin' => $row['linkedin'] ?? null,
            'googlestars' => $row['googlestars'] ?? null,
            'googlereviewscount' => $row['googlereviewscount'] ?? null,
            'yelpstars' => $row['yelpstars'] ?? null,
            'yelpreviewscount' => $row['yelpreviewscount'] ?? null,
            'facebookstars' => $row['facebookstars'] ?? null,
            'facebookreviewscount' => $row['facebookreviewscount'] ?? null,
            'facebookpixel' => $row['facebookpixel'] ?? null,
            'googlepixel' => $row['googlepixel'] ?? null,
            'criteopixel' => $row['criteopixel'] ?? null,
            'seo_schema' => $row['seo_schema'] ?? null,
            'googleanalytics' => $row['googleanalytics'] ?? null,
            'linkedinanalytics' => $row['linkedinanalytics'] ?? null,
            'uses_wordpress' => $row['uses_wordpress'] ?? null,
            'mobilefriendly' => $row['mobilefriendly'] ?? null,
            'uses_shopify' => $row['uses_shopify'] ?? null,
            'domain_registration' => $row['domain_registration'] ?? null,
            'domain_expiration' => $row['domain_expiration'] ?? null,
            'domain_registrar' => $row['domain_registrar'] ?? null,
            'domain_nameserver' => $row['domain_nameserver'] ?? null,
            'instagram_name' => $row['instagram_name'] ?? null,
            'instagram_is_verified' => $row['instagram_is_verified'] ?? null,
            'instagram_is_business_account' => $row['instagram_is_business_account'] ?? null,
            'instagram_media_count' => $row['instagram_media_count'] ?? null,
            'instagram_highlight_reel_count' => $row['instagram_highlight_reel_count'] ?? null,
            'instagram_followers' => $row['instagram_followers'] ?? null,
            'instagram_following' => $row['instagram_following'] ?? null,
            'instagram_category' => $row['instagram_category'] ?? null,
            'instagram_average_likes' => $row['instagram_average_likes'] ?? null,
            'instagram_average_comments' => $row['instagram_average_comments'] ?? null,
            'ads_yelp' => $row['ads_yelp'] ?? null,
            'ads_facebook' => $row['ads_facebook'] ?? null,
            'ads_instagram' => $row['ads_instagram'] ?? null,
            'ads_messenger' => $row['ads_messenger'] ?? null,
            'ads_adwords' => $row['ads_adwords'] ?? null,
            'g_maps_claimed' => $row['g_maps_claimed'] ?? null,
            'g_maps' => $row['g_maps'] ?? null,
            'search_keyword' => $row['search_keyword'] ?? null,
            'search_city' => $row['search_city'] ?? null,
            ]); 
            }
            
        }
    }
}
