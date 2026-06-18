<?php

class SignGenerator
{
    public function generateSignAuth($partner_key, $partner_id, $path, $timestamp)
    {
        $baseString = sprintf("%s%s%d", $partner_id, $path, $timestamp);
        return hash_hmac('sha256', $baseString, $partner_key);
    }

    public function generateSign($partner_key, $partner_id, $path, $timestamp, $access_token, $shop_id)
    {
        $baseString = sprintf("%s%s%d%s%s", $partner_id, $path, $timestamp, $access_token, $shop_id);
        return hash_hmac('sha256', $baseString, $partner_key);
    }
}
