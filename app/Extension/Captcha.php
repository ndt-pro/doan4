<?php

namespace App\Extension;

use Session;
use Response;

class Captcha
{
    public static function putCaptcha() {
        // Check for GD library
        if( !function_exists('gd_info') ) {
            return 'Required GD library is missing';
        }
        $bg_path = public_path('captcha').'/backgrounds/';
        $font_path = public_path('captcha').'/fonts/';

        // Default values
        $captcha_config = array(
            'code' => '',
            'min_length' => 5,
            'max_length' => 5,
            'backgrounds' => array(
                $bg_path.'45-degree-fabric.png',
                $bg_path.'cloth-alike.png',
                $bg_path.'grey-sandbag.png',
                $bg_path.'kinda-jean.png',
                $bg_path.'polyester-lite.png',
                $bg_path.'stitched-wool.png',
                $bg_path.'white-carbon.png',
                $bg_path.'white-wave.png'
            ),
            'fonts' => array(
                $font_path.'font-1.ttf',
                $font_path.'font-3.ttf'
            ),
            'characters' => 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz23456789',
            'min_font_size' => 28,
            'max_font_size' => 28,
            'color' => '#666',
            'angle_min' => 0,
            'angle_max' => 10,
            'shadow' => true,
            'shadow_color' => '#CCC',
            'shadow_offset_x' => -1,
            'shadow_offset_y' => 1
        );

        // Generate CAPTCHA code
        $length = mt_rand($captcha_config['min_length'], $captcha_config['max_length']);
        while(strlen($captcha_config['code']) < $length) {
            $captcha_config['code'] .= substr($captcha_config['characters'], mt_rand() % (strlen($captcha_config['characters'])), 1);
        }
        
        // Generate HTML for image src
        $image_src = route('getcaptcha');

        Session::put('_CAPTCHA', serialize($captcha_config));
    
        return array(
            'code' => $captcha_config['code'],
            'image_src' => $image_src
        );
    }

    public static function getCaptcha() {
        if(Session::has('_CAPTCHA')) {
            $captcha_config = unserialize(Session::get('_CAPTCHA'));
            Session::forget('_CAPTCHA');

            // Pick random background, get info, and start captcha
            $background = $captcha_config['backgrounds'][mt_rand(0, count($captcha_config['backgrounds']) -1)];
            list($bg_width, $bg_height, $bg_type, $bg_attr) = getimagesize($background);

            $captcha = imagecreatefrompng($background);

            $color = self::hex2rgb($captcha_config['color']);
            $color = imagecolorallocate($captcha, $color['r'], $color['g'], $color['b']);

            // Determine text angle
            $angle = mt_rand($captcha_config['angle_min'], $captcha_config['angle_max']) * (mt_rand(0, 1) == 1 ? -1 : 1);

            // Select font randomly
            $font = $captcha_config['fonts'][mt_rand(0, count($captcha_config['fonts']) - 1)];

            // Verify font file exists
            if(!file_exists($font)) echo 'Font file not found: '.$font;

            //Set the font size.
            $font_size = mt_rand($captcha_config['min_font_size'], $captcha_config['max_font_size']);
            $text_box_size = imagettfbbox($font_size, $angle, $font, $captcha_config['code']);

            // Determine text position
            $box_width = abs($text_box_size[6] - $text_box_size[2]);
            $box_height = abs($text_box_size[5] - $text_box_size[1]);
            $text_pos_x_min = 0;
            $text_pos_x_max = ($bg_width) - ($box_width);
            $text_pos_x = mt_rand($text_pos_x_min, $text_pos_x_max);
            $text_pos_y_min = $box_height;
            $text_pos_y_max = ($bg_height) - ($box_height / 2);
            if ($text_pos_y_min > $text_pos_y_max) {
                $temp_text_pos_y = $text_pos_y_min;
                $text_pos_y_min = $text_pos_y_max;
                $text_pos_y_max = $temp_text_pos_y;
            }
            $text_pos_y = mt_rand($text_pos_y_min, $text_pos_y_max);

            // Draw shadow
            if($captcha_config['shadow']) {
                $shadow_color = self::hex2rgb($captcha_config['shadow_color']);
                $shadow_color = imagecolorallocate($captcha, $shadow_color['r'], $shadow_color['g'], $shadow_color['b']);
                imagettftext($captcha, $font_size, $angle, $text_pos_x + $captcha_config['shadow_offset_x'], $text_pos_y + $captcha_config['shadow_offset_y'], $shadow_color, $font, $captcha_config['code']);
            }

            // Draw text
            imagettftext($captcha, $font_size, $angle, $text_pos_x, $text_pos_y, $color, $font, $captcha_config['code']);

            // Output image
            $file = imagepng($captcha);
            return response($file)->header('Content-type','image/png');
        } else {
            echo 'Can not read captcha';
        }
    }

    public static function hex2rgb($hex) {
        $hex      = str_replace('#', '', $hex);
        $length   = strlen($hex);
        $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
        $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
        $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
        return $rgb;
    }
}