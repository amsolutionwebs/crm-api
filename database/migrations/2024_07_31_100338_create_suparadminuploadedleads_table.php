<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    

    public function up(): void
{
    Schema::create('suparadminuploadedleads', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('suparadmin_id');
            $table->foreign('suparadmin_id')
              ->references('id')
              ->on('suparadmins')
              ->onUpdate('cascade')
              ->onDelete('cascade');
        // Adding the fields with string type and nullable
        $table->string('name')->nullable();
        $table->string('phone')->nullable();
        $table->string('email')->nullable();
        $table->string('email_host')->nullable();
        $table->string('website')->nullable();
        $table->string('category')->nullable();
        $table->string('address')->nullable();
        $table->string('city')->nullable();
        $table->string('region')->nullable();
        $table->string('zip')->nullable();
        $table->string('country')->nullable();
        $table->string('google_rank')->nullable();
        $table->string('facebook')->nullable();
        $table->string('instagram')->nullable();
        $table->string('twitter')->nullable();
        $table->string('linkedin')->nullable();
        $table->string('googlestars')->nullable();
        $table->string('googlereviewscount')->nullable();
        $table->string('yelpstars')->nullable();
        $table->string('yelpreviewscount')->nullable();
        $table->string('facebookstars')->nullable();
        $table->string('facebookreviewscount')->nullable();
        $table->string('facebookpixel')->nullable();
        $table->string('googlepixel')->nullable();
        $table->string('criteopixel')->nullable();
        $table->string('seo_schema')->nullable();
        $table->string('googleanalytics')->nullable();
        $table->string('linkedinanalytics')->nullable();
        $table->string('uses_wordpress')->nullable();
        $table->string('mobilefriendly')->nullable();
        $table->string('uses_shopify')->nullable();
        $table->string('domain_registration')->nullable();
        $table->string('domain_expiration')->nullable();
        $table->string('domain_registrar')->nullable();
        $table->string('domain_nameserver')->nullable();
        $table->string('instagram_name')->nullable();
        $table->string('instagram_is_verified')->nullable();
        $table->string('instagram_is_business_account')->nullable();
        $table->string('instagram_media_count')->nullable();
        $table->string('instagram_highlight_reel_count')->nullable();
        $table->string('instagram_followers')->nullable();
        $table->string('instagram_following')->nullable();
        $table->string('instagram_category')->nullable();
        $table->string('instagram_average_likes')->nullable();
        $table->string('instagram_average_comments')->nullable();
        $table->string('ads_yelp')->nullable();
        $table->string('ads_facebook')->nullable();
        $table->string('ads_instagram')->nullable();
        $table->string('ads_messenger')->nullable();
        $table->string('ads_adwords')->nullable();
        $table->string('g_maps_claimed')->nullable();
        $table->string('g_maps')->nullable();
        $table->string('search_keyword')->nullable();
        $table->string('search_city')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suparadminuploadedleads');
    }
};
